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
        } elseif ($entry->death != 0) {
            $entry->entry_type = 'death';
            $entry->quantity = $entry->death;
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


        public function getBatches()
    {
        $batches = ChickenBatch::orderBy('batch_code')
                      ->get(['id', 'batch_code']);

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
        'entry_date'   => 'required|date',
        'entry_type'   => 'required|in:death,slaughter,sold',
        'quantity'     => 'required|integer|min:1',
        'remarks'      => 'nullable|string|max:255',
    ]);

    try {
        DB::beginTransaction();

        // Initialize fields for chicken_entries
        $dead = 0;
        $slaughtered = 0;
        $sold = 0;

        if ($request->entry_type === 'death') {
            $dead = $request->quantity;
        } elseif ($request->entry_type === 'slaughter') {
            $slaughtered = $request->quantity;
        } elseif ($request->entry_type === 'sold') {
            $sold = $request->quantity;
        }

        // Save entry
        $entry = ChickenEntry::create([
            'batch_code'   => $request->batch_code,
            'entry_date'   => $request->entry_date,
            'slaughtered'  => $slaughtered,
            'dead'         => $dead,
            'sold'         => $sold,
            'remarks'      => $request->remarks
        ]);

        // Update stock
        $stock = ChickenStock::where('batch_code', $request->batch_code)->firstOrFail();

        // Update values
        $stock->dead        += $dead;
        $stock->slaughtered += $slaughtered;
        $stock->sold        += $sold;

        // Recalculate derived fields
       // $stock->unslaughtered_remaining = $stock->starting_total - $stock->dead - $stock->slaughtered;
       // $stock->slaughtered_unsold     = $stock->slaughtered - $stock->sold;
        $stock->total_remaining        = $stock->unslaughtered_remaining + $stock->slaughtered_unsold;

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
        'entry_type' => 'required|string|in:death,slaughtered,sold', // validate entry_type
    ]);

    try {
        DB::beginTransaction();

        $entry = ChickenEntry::findOrFail($id);
        $stock = ChickenStock::where('batch_code', $entry->batch_code)->firstOrFail();

        $oldQty = 0;
        $column = null;

        // Use the entry_type from the request, NOT from DB
        $type = strtolower(trim($request->entry_type));

        switch ($type) {
            case 'death':
                $oldQty = $entry->dead;
                $column = 'dead';
                break;
            case 'slaughtered':
                $oldQty = $entry->slaughtered;
                $column = 'slaughtered';
                break;
            case 'sold':
                $oldQty = $entry->sold;
                $column = 'sold';
                break;
        }

        if ($column === null) {
            throw new \Exception('Invalid entry type.');
        }

        $newQty = $request->quantity;
        $diff = $newQty - $oldQty;

        // Update entry and stock
        $entry->$column = $newQty;
        $entry->save();

        $stock->$column += $diff;

     

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
