<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DynamicStoredProcedureService
{
    public function execute(string $spName, array $params)
    {
    

        $sqlParams = [];
        $bindings = [];

        foreach ($params as $key => $value) {
            $sqlParams[] = "@$key = ?";
            $bindings[] = $value;
        }

        $sql = 'EXEC ' . $spName . ' ' . implode(', ', $sqlParams);

        return DB::select($sql, $bindings);
    }
}
