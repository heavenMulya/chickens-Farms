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

    // Validate 'entry_type' is present and either 'daily' or 'sales'
    $request->validate([
        'entry_type' => 'required|in:daily,sales',
    ]);

    if ($entryType === 'daily') {
        // Validate daily entry fields
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


        // Create or update record for this date (if exists)
        $egg = Egg::updateOrCreate(
            ['batch_code' => $request->batch_code],
            [
                'total_eggs' => $total,
                'broken_eggs' => $broken,
                'good_eggs' => $good,
            ]
        );

        return response()->json([
            'message' => 'Daily eggs record saved successfully.',
            'data' => $egg
        ], 201);

    } elseif ($entryType === 'sales') {
        // Validate sales entry fields
        $request->validate([
            'batch_code' => 'required|string|exists:chicken_stocks,batch_code',
            'sold_eggs' => 'required|integer|min:0',
        ]);

         // Create or update record for this date (if exists)
        $egg = Egg::updateOrCreate(
            ['batch_code' => $request->batch_code],
            [
                'sold_eggs' => $request->sold_eggs,
            ]
        );

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

    // Find the egg record by date
    $egg = Egg::where('id', $id)->first();

    if (!$egg) {
        return response()->json([
            'error' => 'Egg record not found for the given ID.'
        ], 404);
    }

            $total = (int) trim($request->total_eggs);
$broken = (int) trim($request->broken_eggs);
$good = (int) trim($request->good_eggs);

if ($total !== ($broken + $good)) {
    return response()->json([
        'error' => 'Total eggs must be equal to broken eggs plus good eggs.'
    ], 422);
}

        // Update daily fields
        $egg->total_eggs = $request->total_eggs;
        $egg->broken_eggs = $request->broken_eggs;
        $egg->good_eggs = $request->good_eggs;
        $egg->sold_eggs = $request->sold_eggs;

        $egg->save();

        return response()->json([
            'message' => 'Daily egg record updated successfully.',
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
