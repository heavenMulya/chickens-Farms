<?php

namespace App\Http\Controllers\eggs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Egg;

class EggController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eggs = Egg::paginate(10);
    return response()->json([
        'data' => $eggs
    ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $entryType = $request->input('entry_type');

    $request->validate([
        'entry_type' => 'required|in:daily,sales',
    ]);

    if ($entryType === 'daily') {
        $request->validate([
            'batch_code' => 'required|string|exists:chicken_stocks,batch_code',
            'total_eggs' => 'required|integer|min:0',
            'broken_eggs' => 'required|integer|min:0',
            'good_eggs' => 'required|integer|min:0',
            'remarks' => 'required|string',
        ]);

        $total = (int) trim($request->total_eggs);
        $broken = (int) trim($request->broken_eggs);
        $good = (int) trim($request->good_eggs);

        if ($total !== ($broken + $good)) {
            return response()->json([
                'error' => 'Total eggs must be equal to broken eggs plus good eggs.'
            ], 422);
        }

        $egg = Egg::updateOrCreate(
            ['batch_code' => $request->batch_code],
            [
                'total_eggs' => $total,
                'broken_eggs' => $broken,
                'good_eggs' => $good,
                'remarks' => $request->remarks,
            ]
        );

        return response()->json([
            'message' => 'Daily eggs record saved successfully.',
            'data' => $egg
        ], 201);

    } elseif ($entryType === 'sales') {
        $request->validate([
            'batch_code' => 'required|string|exists:chicken_stocks,batch_code',
            'sold_eggs' => 'required|integer|min:0',
             'pending_order_id' => 'required|string',
        ]);

         \App\Models\Order::where('id', $request->pending_order_id)
        ->where('sales_status', 'pending')
        ->update([
            'sales_status' => 'completed'
        ]);

        $egg = Egg::where('batch_code', $request->batch_code)->first();

        if (!$egg) {
            return response()->json(['error' => 'No egg record found for this batch.'], 404);
        }

        if ($request->sold_eggs > $egg->good_eggs) {
            return response()->json([
                'error' => 'Sold eggs cannot be greater than available good eggs.'
            ], 422);
        }

        $egg->sold_eggs = $request->sold_eggs;
        $egg->ORDER_ID = $request->pending_order_id;
        $egg->save();

        return response()->json([
            'message' => 'Sales quantity updated successfully.',
            'data' => $egg
        ], 200);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $egg = Egg::where('id', $id)->first();

    if (!$egg) {
        return response()->json([
            'error' => 'Egg record not found for the given ID.'
        ], 404);
    }

    return response()->json([
        'data' => $egg
    ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $egg = Egg::find($id);

    if (!$egg) {
        return response()->json([
            'error' => 'Egg record not found for the given ID.'
        ], 404);
    }

    $request->validate([
        'total_eggs' => 'required|integer|min:0',
        'broken_eggs' => 'required|integer|min:0',
        'good_eggs' => 'required|integer|min:0',
        'sold_eggs' => 'nullable|integer|min:0',
        'remarks' => 'nullable|string',
    ]);

    $total = (int) trim($request->total_eggs);
    $broken = (int) trim($request->broken_eggs);
    $good = (int) trim($request->good_eggs);
    $sold = (int) $request->sold_eggs ?? 0;

    if ($total !== ($broken + $good)) {
        return response()->json([
            'error' => 'Total eggs must be equal to broken eggs plus good eggs.'
        ], 422);
    }

    if ($sold > $good) {
        return response()->json([
            'error' => 'Sold eggs cannot be greater than good eggs.'
        ], 422);
    }

    $egg->total_eggs = $total;
    $egg->broken_eggs = $broken;
    $egg->good_eggs = $good;
    $egg->sold_eggs = $sold;
    $egg->remarks = $request->remarks ?? $egg->remarks;
    $egg->save();

    return response()->json([
        'message' => 'Egg record updated successfully.',
        'data' => $egg
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
  
  public function destroy($id)
{
    $egg = Egg::where('id', $id)->first();

    if (!$egg) {
        return response()->json([
            'error' => 'Egg record not found for the given ID.'
        ], 404);
    }

    $egg->delete();

    return response()->json([
        'message' => 'Egg record deleted successfully.'
    ], 200);
}

  public function searching(Request $request)
{
    $perPage = $request->get('per_page', 10);

    $query = Egg::query();

    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where('batch_code', 'like', "%{$search}%");
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
