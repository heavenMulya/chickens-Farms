<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class testingdynamic extends Controller
{

   public function create(Request $request)
{
    $request->validate([
        'sp_name' => 'required|string', // e.g., RMASTER.SAVE_BRANCH_MASTER
        'params'  => 'required|array'   // e.g., { "COMPANY_ID": 1, "BRANCH_NAME": "ABC" }
    ]);

    $spName = $request->input('sp_name');
    $params = $request->input('params');

    // Add default parameters
    $params['CREATED_BY'] = auth()->user()->name ?? 'admin';
    $params['CREATED_MAC_ADDRESS'] = $request->ip();

    // Prepare SQL part
    $sqlParams = [];
    $bindings = [];

    foreach ($params as $key => $value) {
        $sqlParams[] = "@$key = ?";
        $bindings[] = $value;
    }

    $sql = 'EXEC ' . $spName . ' ' . implode(', ', $sqlParams);

    try {
        $result = DB::select($sql, $bindings);

        $response = $result[0] ?? null;
        $statusType = $response->Column1 ?? 'Success';
        $message = $response->Column2 ?? 'Operation successful.';

        return response()->json([
            'status'  => $statusType,
            'message' => $message,
            'data'    => $result
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'Error',
            'message' => $e->getMessage()
        ], 500);
    }
}

}
