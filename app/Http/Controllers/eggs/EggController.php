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
        $eggs = Egg::all();
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
            'record_date' => 'required|date',
            'total_eggs' => 'required|integer|min:0',
            'broken_eggs' => 'required|integer|min:0',
            'good_eggs' => 'required|integer|min:0',
            'remarks' => 'required|string',
        ]);

        if ($request->total_eggs !== ($request->broken_eggs + $request->good_eggs)) {
            return response()->json([
                'error' => 'Total eggs must be equal to broken eggs plus good eggs.'
            ], 422);
        }

        // Create or update record for this date (if exists)
        $egg = Egg::updateOrCreate(
            ['record_date' => $request->record_date],
            [
                'total_eggs' => $request->total_eggs,
                'broken_eggs' => $request->broken_eggs,
                'good_eggs' => $request->good_eggs,
            ]
        );

        return response()->json([
            'message' => 'Daily eggs record saved successfully.',
            'data' => $egg
        ], 201);

    } elseif ($entryType === 'sales') {
        // Validate sales entry fields
        $request->validate([
            'record_date' => 'required|date',
            'sold_eggs' => 'required|integer|min:0',
        ]);

        // Find existing record for this date
        $egg = Egg::where('record_date', $request->record_date)->first();

        if (!$egg) {
            return response()->json([
                'error' => 'No egg record found for this date. Please enter daily data first.'
            ], 404);
        }

        // Update sold_eggs by adding the new sold quantity
        $egg->sold_eggs += $request->sold_eggs;
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
    $entryType = $request->input('entry_type');

    // Validate 'entry_type'
    $request->validate([
        'entry_type' => 'required|in:daily,sales',
    ]);

    // Find the egg record by date
    $egg = Egg::where('id', $id)->first();

    if (!$egg) {
        return response()->json([
            'error' => 'Egg record not found for the given ID.'
        ], 404);
    }

    if ($entryType === 'daily') {
        // Validate daily fields
        $request->validate([
            'total_eggs' => 'required|integer|min:0',
            'broken_eggs' => 'required|integer|min:0',
            'good_eggs' => 'required|integer|min:0',
        ]);

        if ($request->total_eggs !== ($request->broken_eggs + $request->good_eggs)) {
            return response()->json([
                'error' => 'Total eggs must be equal to broken eggs plus good eggs.'
            ], 422);
        }

        // Update daily fields
        $egg->total_eggs = $request->total_eggs;
        $egg->broken_eggs = $request->broken_eggs;
        $egg->good_eggs = $request->good_eggs;

        $egg->save();

        return response()->json([
            'message' => 'Daily egg record updated successfully.',
            'data' => $egg
        ], 200);

    } elseif ($entryType === 'sales') {
        // Validate sales field
        $request->validate([
            'sold_eggs' => 'required|integer|min:0',
        ]);

        // Update sold_eggs (overwrite or add? Let's overwrite for update)
        $egg->sold_eggs = $request->sold_eggs;
        $egg->save();

        return response()->json([
            'message' => 'Sales quantity updated successfully.',
            'data' => $egg
        ], 200);
    }
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

}
