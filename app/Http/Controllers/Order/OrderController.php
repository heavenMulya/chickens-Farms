<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Str;


class OrderController extends Controller
{

     public function index()
    {
        $orders = Order::with('items')->orderByDesc('created_at')->paginate(10);
        return response()->json(['data'=>$orders]);
    }

  public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email',
        'phone_number' => 'required',
        'description' => 'nullable|string',
        'amount' => 'required|numeric',
        'currency' => 'required|string',
        'delivery_option' => 'required|string',
        'payment_method' => 'required|string',
        'products' => 'required|array',
    ]);

    $order = Order::create($validated); // or map manually

    // Optionally save order items
    foreach ($request->products as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['id'],
            'title' => $item['title'],
            'price' => $item['price'],
            'quantity' => $item['quantity'],
        ]);
    }

    return response()->json([
        'success' => true,
        'order_id' => $order->id
    ]);

}

 public function show($id)
    {
        $order = Order::with('items')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

 public function updateOrderStatus($id, Request $request)
{
    $request->validate([
        'status' => 'required|string|in:cancelled,paid',
        'cancel_reason' => 'nullable|string|max:1000',  // Allow optional cancel reason
    ]);

    $user = User::where('api_token', $request->bearerToken())->first();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $order = Order::where('id', $id)->where('user_id', $user->id)->first();

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    if ($order->status === 'delivered') {
        return response()->json(['message' => 'Cannot change status of a delivered order'], 400);
    }

    // Update status
    $order->status = $request->status;

    // If status is cancelled, save the reason if provided
    if ($request->status === 'cancelled' && $request->filled('cancel_reason')) {
        $order->cancel_reason = $request->cancel_reason;
    } else {
        // Optional: clear cancel_reason if not cancelled or not provided
        $order->cancel_reason = null;
    }

    $order->save();

    return response()->json([
        'message' => "Order marked as {$request->status} successfully",
        'order' => $order
    ]);
}

 public function updateOrderStatusAdmin($id, Request $request)
{
    $request->validate([
        'status' => 'required|string|in:cancelled,paid',
        'cancel_reason' => 'nullable|string|max:1000',  // Allow optional cancel reason
    ]);


    $order = Order::where('id', $id)->first();

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    if ($order->status === 'delivered') {
        return response()->json(['message' => 'Cannot change status of a delivered order'], 400);
    }

    // Update status
    $order->status = $request->status;

    // If status is cancelled, save the reason if provided
    if ($request->status === 'cancelled' && $request->filled('cancel_reason')) {
        $order->cancel_reason = $request->cancel_reason;
    } else {
        // Optional: clear cancel_reason if not cancelled or not provided
        $order->cancel_reason = null;
    }

    $order->save();

    return response()->json([
        'message' => "Order marked as {$request->status} successfully",
        'order' => $order
    ]);
}



 public function viewUserOrders(Request $request)
{
    $user = User::where('api_token', $request->bearerToken())->first();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $query = Order::where('user_id', $user->id)
        ->with(['items.product']) // Eager load items + product
        ->orderBy('created_at', 'desc');

    // Optional filters
    if ($request->filled('status')) {
        $status = strtolower($request->status);
        $query->where('status', $status);
    }

    if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }

    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('id', $search)
              ->orWhere('status', 'like', "%$search%")
              ->orWhereHas('items', function ($q2) use ($search) {
                  $q2->where('title', 'like', "%$search%");
              });
        });
    }

    $orders = $query->get();

    // ✅ Transform product image paths to full URLs
  foreach ($orders as $order) {
    foreach ($order->items as $item) {
        if ($item->product && $item->product->image) {
            if (!Str::startsWith($item->product->image, ['http://', 'https://'])) {
                $item->product->image = asset('storage/' . $item->product->image);
            }
        }
    }
}

    return response()->json([
        'message' => 'User orders fetched successfully',
        'orders' => $orders,
    ]);
}



public function reorder(Request $request, $id)
{
    $user = User::where('api_token', $request->bearerToken())->first();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $order = Order::where('id', $id)->where('user_id', $user->id)->first();

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    // Eager load product with order items
    $items = OrderItem::with('product')
        ->where('order_id', $order->id)
        ->get();

    // Process each item image URL to ensure full path
    foreach ($items as $item) {
        if ($item->product && $item->product->image) {
            if (!Str::startsWith($item->product->image, ['http://', 'https://'])) {
                $item->product->image = asset('storage/' . $item->product->image);
            }
        }
    }

    return response()->json([
        'message' => 'Items added successfully',
        'items' => $items->map(function ($item) {
            return [
                'id' => $item->product_id,
                'title' => $item->title,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'image' => $item->product ? $item->product->image : ''
            ];
        })
    ]);
}




  public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->items()->delete();
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
    


    public function receipt($id)
{
    $order = Order::with(['items.product', 'user'])->find($id);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    // Calculate totals
    $subtotal = $order->items->sum(function ($item) {
        return floatval($item->price) * intval($item->quantity);
    });

    // Process product images to full URLs
    foreach ($order->items as $item) {
        if ($item->product && $item->product->image) {
            if (!Str::startsWith($item->product->image, ['http://', 'https://'])) {
                $item->product->image = asset('storage/' . $item->product->image);
            }
        }
    }

    // Format the receipt data
    $receiptData = [
        'id' => $order->id,
        'status' => $order->status,
        'amount' => floatval($order->amount),
        'currency' => $order->currency ?? 'TZS',
        'payment_method' => $order->payment_method ?? 'Not specified',
        'delivery_option' => $order->delivery_option ?? 'Not specified',
        'description' => $order->description,
        'created_at' => $order->created_at,
        'updated_at' => $order->updated_at,
        'paid_at' => $order->updated_at, // Using updated_at as paid_at if not available
        
        // Customer information
        'customer_name' => trim(($order->first_name ?? '') . ' ' . ($order->last_name ?? '')) ?: ($order->user->name ?? 'N/A'),
        'customer_email' => $order->email ?? ($order->user->email ?? 'N/A'),
        'customer_phone' => $order->phone_number ?? ($order->user->phone ?? 'N/A'),
        
        // User relationship data
        'user' => $order->user ? [
            'id' => $order->user->id,
            'name' => $order->user->name,
            'email' => $order->user->email,
            'phone' => $order->user->phone ?? 'N/A',
        ] : null,
        
        // Order items with product details
        'items' => $order->items->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'title' => $item->title,
                'price' => floatval($item->price),
                'quantity' => intval($item->quantity),
                'total' => floatval($item->price) * intval($item->quantity),
                'product' => $item->product ? [
                    'id' => $item->product->id,
                    'title' => $item->product->title,
                    'image' => $item->product->image,
                    'description' => $item->product->description ?? null,
                ] : null
            ];
        }),
        
        // Calculated totals
        'subtotal' => $subtotal,
        'tax' => 0.00, // Add tax calculation if needed
        'delivery_fee' => 0.00, // Add delivery fee calculation if needed
        'total_amount' => floatval($order->amount),
        
        // Receipt metadata
        'transaction_id' => 'TXN' . $order->id . substr(time(), -6),
        'receipt_generated_at' => now(),
    ];

    return response()->json([
        'success' => true,
        'message' => 'Receipt generated successfully',
        'order' => $receiptData
    ]);
}

public function getPendingOrders(Request $request)
{
    $request->validate([
        'batch_type' => 'required|string|in:meat,eggs',
    ]);

    $batchType = strtolower($request->batch_type);

    $pendingOrders = Order::with(['items.product'])
        ->where('sales_status', 'pending') // only pending orders
        ->where('status', 'paid') 
        ->whereHas('items.product', function ($q) use ($batchType) {
            $q->where('batch_type', $batchType);
        })
        ->orderByDesc('created_at')
        ->get();

    return response()->json([
        'message' => "Pending {$batchType} orders fetched successfully",
        'orders' => $pendingOrders
    ]);
}


 public function searching(Request $request)
{
    $perPage = $request->get('per_page', 10);

    $query = Order::query();

    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where('sales_status', 'like', "%{$search}%");
    }

    $products = $query->paginate($perPage);

    // 🔁 Transform image to full URL
    $products->getCollection()->transform(function ($product) {
        if ($product->image) {
            $product->image = asset('storage/' . $product->image);
        }
        return $product;
    });

    return response()->json([
        'data' => $products
    ]);
}
}