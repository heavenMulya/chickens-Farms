<?php

namespace App\Http\Controllers\chickens;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ChickenEntry;
use App\Models\ChickenStock;
use App\Models\ChickenBatch;
use Illuminate\Support\Facades\DB;

class ChickenEntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $entries = ChickenEntry::orderBy('entry_date', 'desc')->paginate(10);

    $entries->getCollection()->transform(function ($entry) {
        if ($entry->sold != 0) {
            $entry->entry_type = 'sold';
            $entry->quantity = $entry->sold;
        } elseif ($entry->dead != 0) {
            $entry->entry_type = 'death';
            $entry->quantity = $entry->dead;
        } elseif ($entry->slaughtered != 0) {
            $entry->entry_type = 'slaughtered';
            $entry->quantity = $entry->slaughtered;
        } else {
            $entry->entry_type = 'unknown';
            $entry->quantity = 0;
        }

     

        return $entry;
    });

    return response()->json([
        'success' => true,
        'data' => $entries
    ]);
}



public function getBatches(Request $request)
{
    $type = $request->input('type'); // expects 'broiler' or 'layer'

    $query = ChickenBatch::query();

    if ($type === 'broiler') {
        $query->where('batch_type', 'broiler');
    } elseif ($type === 'layer') {
        $query->where('batch_type', 'layer');
    }

    $batches = $query->orderBy('batch_code')->get(['id', 'batch_code']);

    return response()->json([
        'success' => true,
        'data'    => $batches,
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'batch_code'   => 'required|exists:chicken_stocks,batch_code',
        'entry_type'   => 'required|in:death,slaughter,sold',
        'quantity'     => 'required|integer|min:1',
        'remarks'      => 'nullable|string|max:255',
    ]);

    try {
        DB::beginTransaction();

        $stock = ChickenStock::where('batch_code', $request->batch_code)->firstOrFail();
        $quantity = (int) $request->quantity;

        $dead = 0;
        $slaughtered = 0;
        $sold = 0;

        // Calculate remaining chickens
        $used = $stock->dead + $stock->slaughtered;
        $remaining = $stock->starting_total - $used;

        if ($request->entry_type === 'death') {
            if ($quantity > $remaining) {
                return response()->json(['error' => 'Death quantity exceeds remaining chickens.'], 422);
            }
            $dead = $quantity;

        } elseif ($request->entry_type === 'slaughter') {
            if ($quantity > $remaining) {
                return response()->json(['error' => 'Slaughter quantity exceeds remaining chickens.'], 422);
            }
            $slaughtered = $quantity;

        } elseif ($request->entry_type === 'sold') {
            if ($stock->sold + $quantity > $stock->slaughtered) {
                return response()->json(['error' => 'Sold quantity exceeds slaughtered quantity.'], 422);
            }
            $sold = $quantity;

            \App\Models\Order::where('id', $request->pending_order_id)
        ->where('sales_status', 'pending')
        ->update([
            'sales_status' => 'completed'
        ]);
        }

        $entry = ChickenEntry::create([
            'batch_code'   => $request->batch_code,
            'entry_date'   => now(), // Automatically use current timestamp
            'slaughtered'  => $slaughtered,
            'dead'         => $dead,
            'sold'         => $sold,
            'remarks'      => $request->remarks
        ]);

        // Update stock values
        $stock->dead += $dead;
        $stock->slaughtered += $slaughtered;
        $stock->sold += $sold;

        $stock->total_remaining = $stock->unslaughtered_remaining + $stock->slaughtered_unsold;
        $stock->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Chicken entry and stock updated successfully',
            'data'    => $entry
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Failed to save chicken entry',
            'error'   => $e->getMessage()
        ], 500);
    }
}





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $entry = ChickenEntry::find($id);

    if (!$entry) {
        return response()->json([
            'success' => false,
            'message' => 'Entry not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $entry
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
        'entry_type' => 'required|string|in:death,slaughtered,sold',
    ]);

    try {
        DB::beginTransaction();

        $entry = ChickenEntry::findOrFail($id);
        $stock = ChickenStock::where('batch_code', $entry->batch_code)->firstOrFail();

        $newQty = (int) $request->quantity;
        $type = strtolower(trim($request->entry_type));

        $oldQty = 0;
        $column = null;

        switch ($type) {
            case 'death':
                $oldQty = $entry->dead;
                $column = 'dead';

                $used = $stock->dead + $stock->slaughtered - $oldQty;
                $remaining = $stock->starting_total - $used;
                if ($newQty > $remaining) {
                    return response()->json(['error' => 'Death quantity exceeds remaining chickens which is.'.$remaining], 422);
                }
                break;

            case 'slaughtered':
                $oldQty = $entry->slaughtered;
                $column = 'slaughtered';

                $used = $stock->dead + $stock->slaughtered - $oldQty;
                $remaining = $stock->starting_total - $used;
                if ($newQty > $remaining) {
                    return response()->json(['error' => 'Slaughter quantity exceeds remaining chickens which is.'.$remaining], 422);
                }
                break;

            case 'sold':
                $oldQty = $entry->sold;
                $column = 'sold';

                $currentSold = $stock->sold - $oldQty;
                if ($currentSold + $newQty > $stock->slaughtered) {
                    return response()->json(['error' => 'Sold quantity exceeds slaughtered quantity which is.'. $stock->slaughtered], 422);
                }
                \App\Models\Order::where('id', $request->order_id)
        ->where('sales_status', 'pending')
        ->update([
            'sales_status' => 'completed',
            'status' => 'completed'
        ]);
                break;

            default:
                return response()->json(['error' => 'Invalid entry type'], 400);
        }

        // Update entry with new quantity and current timestamp
        $entry->$column = $newQty;
        $entry->entry_date = now(); // Update entry date to current time
        $entry->save();

        // Update stock
        $stock->$column = ($stock->$column - $oldQty) + $newQty;
        $stock->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated successfully',
            'data' => $entry
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Failed to update quantity',
            'error' => $e->getMessage()
        ], 500);
    }
}




    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
{
    try {
        DB::beginTransaction();

        $entry = ChickenEntry::where('id', $id)->first();
        $stock = ChickenStock::where('batch_code', $entry->batch_code)->first();

        if (!$entry || !$stock) {
            throw new \Exception('Entry or stock record not found.');
        }

        // Determine entry type based on non-zero values
        if ($entry->death != 0) {
            $stock->dead -= $entry->death;
        } elseif ($entry->slaughtered != 0) {
            $stock->slaughtered -= $entry->slaughtered;
        } elseif ($entry->sold != 0) {
            $stock->sold -= $entry->sold;
        } else {
            throw new \Exception('Cannot determine entry type from entry data.');
        }

        // Recalculate derived fields
        //$stock->unslaughtered_remaining = $stock->starting_total - $stock->dead - $stock->slaughtered;
        //$stock->slaughtered_unsold     = $stock->slaughtered - $stock->sold;
      //  $stock->total_remaining        = $stock->unslaughtered_remaining + $stock->slaughtered_unsold;

        $stock->save();

        $entry->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Entry deleted and stock updated successfully',
        ]);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete entry',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function searching(Request $request)
{
    $perPage = $request->get('per_page', 10);

    $query = ChickenEntry::query();

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
