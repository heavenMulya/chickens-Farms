<?php

namespace App\Http\Controllers\chickens;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ChickenBatch;
use App\Models\ChickenStock;
use App\Models\daily_expenses;
use App\Models\ChickenEntry;
use App\Models\Egg;
use Illuminate\Support\Facades\DB;

class ChickenBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = ChickenBatch::paginate(10);

    return response()->json([
        'success' => true,
        'data' => $batches
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
        'supplier_name' => 'nullable|string|max:100',
            'batch_type' => 'required|string|in:broiler,layer' 
    ]);

    try {
        DB::beginTransaction();

        // Insert without batch_code, trigger will create it
        $batch = ChickenBatch::create([
                  'arrival_date' => now()->toDateString(),
            'Quantity' => $request->quantity,
            'batch_type' => $request->batch_type,
            //'supplier_name' => $request->supplier_name
        ]);
           $batch->refresh();
        // Retrieve the batch_code generated by the trigger
        $batch_code = $batch->batch_code;
        $starting_total = $batch->Quantity;

        // Save stock for the batch
        ChickenStock::create([
            'batch_code' => $batch_code,
            'starting_total' => $starting_total,
            'dead' => 0,
            'slaughtered' => 0,
            'sold' => 0
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Chicken batch and stock recorded successfully',
            'data' => $batch
        ]);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Error saving chicken data',
            'error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $batch_code)
    {
        $batch = ChickenBatch::where('batch_code', $batch_code)->first();

    if (!$batch) {
        return response()->json([
            'success' => false,
            'message' => 'Batch not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $batch
    ]);
    
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
            'batch_type' => 'required|string|in:broiler,layer' 
    ]);

    try {
        DB::beginTransaction();

        // Find the batch by batch_code
        $batch = ChickenBatch::where('id', $id)->firstOrFail();

        // Update number_of_chickens
        $batch->update([
            'Quantity' => $request->quantity,
            'batch_type' => $request->batch_type,
            'arrival_date' => now()->toDateString(),
        ]);
        

          // Retrieve updated batch from DB
        $updatedBatch = ChickenBatch::where('id', $id)->first();
        $batchCode = $updatedBatch->batch_code;

        // Use updated value to update starting_total in stock
        ChickenStock::where('batch_code', $batchCode)->update([
            'starting_total' => $updatedBatch->Quantity,
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Chicken batch and stock quantity updated successfully',
            'data' => $batch
        ]);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Error updating chicken data',
            'error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */


public function destroy(string $id)
{
    try {
        DB::beginTransaction();

        $batch = ChickenBatch::findOrFail($id);
        $batchCode = $batch->batch_code;

        // 🚫 Check if batch is used in Daily Expenses
        if (daily_expenses::where('batch_code', $batchCode)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete batch. It is linked to expense records.'
            ], 403);
        }

        // 🚫 Check if batch is used in Chicken Entries
        if (ChickenEntry::where('batch_code', $batchCode)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete batch. It is linked to chicken entry records.'
            ], 403);
        }

        // 🚫 Check if batch is used in Egg Records
        if (Egg::where('batch_code', $batchCode)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete batch. It is linked to egg collection records.'
            ], 403);
        }

        // ✅ Safe to delete
        ChickenStock::where('batch_code', $batchCode)->delete();
        $batch->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Batch and its stock deleted successfully.'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete batch.',
            'error' => $e->getMessage()
        ], 500);
    }
}


       public function searching(Request $request)
{
    $perPage = $request->get('per_page', 10);

    $query = ChickenBatch::query();

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
