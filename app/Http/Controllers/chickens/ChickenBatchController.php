<?php

namespace App\Http\Controllers\chickens;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ChickenBatch;
use App\Models\ChickenStock;
use Illuminate\Support\Facades\DB;

class ChickenBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = ChickenBatch::paginate(5);;

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
        'arrival_date' => 'required|date',
        'quantity' => 'required|integer|min:1',
        'supplier_name' => 'nullable|string|max:100'
    ]);

    try {
        DB::beginTransaction();

        // Insert without batch_code, trigger will create it
        $batch = ChickenBatch::create([
            'arrival_date' => $request->arrival_date,
            'Quantity' => $request->quantity,
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
  public function update(Request $request, $batch_code)
{
    $request->validate([
        'Quantity' => 'required|integer|min:1',
    ]);

    try {
        DB::beginTransaction();

        // Find the batch by batch_code
        $batch = ChickenBatch::where('batch_code', $batch_code)->firstOrFail();

        // Update number_of_chickens
        $batch->update([
            'Quantity' => $request->Quantity,
        ]);
        

          // Retrieve updated batch from DB
        $updatedBatch = ChickenBatch::where('batch_code', $batch_code)->first();

        // Use updated value to update starting_total in stock
        ChickenStock::where('batch_code', $batch_code)->update([
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
        //
    }
}
