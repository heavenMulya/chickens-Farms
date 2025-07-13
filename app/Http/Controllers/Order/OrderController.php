<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;

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
    // Get authenticated user
    $user = auth()->user();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Start query for user's orders
    $query = Order::where('user_id', $user->id)->with('items')->orderBy('created_at', 'desc');

    // Apply status filter if provided (case insensitive)
    if ($request->filled('status')) {
        $status = strtolower($request->status);
        $query->where('status', $status);
    }

    // Apply from_date filter if provided (created_at >= from_date)
    if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }

    // Apply to_date filter if provided (created_at <= to_date)
    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }

    // Apply search filter if provided
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('id', $search) // search by exact order id
              ->orWhere('status', 'like', "%$search%") // status partial match
              ->orWhereHas('items', function ($q2) use ($search) { // item title partial match
                  $q2->where('title', 'like', "%$search%");
              });
        });
    }

    // Execute query and get orders
    $orders = $query->get();

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

    $items = OrderItem::where('order_id', $order->id)
        ->get(['product_id', 'title', 'price', 'quantity']);

  

    return response()->json([
    'message' => 'Items added successfully',
    'items' => $items->map(function ($item) {
        return [
            'id' => $item->product_id,
            'title' => $item->title,
            'price' => $item->price,
            'quantity' => $item->quantity,
            'image' => $item->image ?? 'https://via.placeholder.com/60x60?text=🍗'
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
    

}