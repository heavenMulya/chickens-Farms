<?php
namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\DynamicStoredProcedureService;
use App\Http\Requests\SaveBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Http\Requests\DeleteBranchRequest;

class DynamicSPController extends Controller
{

    public function loadDropdownData(DynamicStoredProcedureService $spService)
{
 try {
    $companyId  = request()->input('company_id');
    $branchId   = request()->input('branch_id');
    $buildingId = request()->input('building_id');
    $floorId    = request()->input('floor_id');

    $dropdowns = [];

    // 1. Load Branches if company_id given
    if ($companyId) {
        $dropdowns['branches'] = $spService->execute('RMASTER.GET_BRANCHES_BY_COMPANY_ID', [
            'COMPANY_ID' => $companyId
        ]);
    }

    // 2. Load Buildings if company_id + branch_id given
    if ($companyId && $branchId) {
        $dropdowns['buildings'] = $spService->execute('RMASTER.GET_BUILDINGS_BY_COMPANY_AND_BRANCH', [
            'COMPANY_ID' => $companyId,
            'BRANCH_ID'  => $branchId
        ]);
    }

    // 3. Load Floors if company_id + branch_id + building_id given
    if ($companyId && $branchId && $buildingId) {
        $dropdowns['floors'] = $spService->execute('RMASTER.GET_FLOORS_BY_COMPANY_BRANCH_BUILDING', [
            'COMPANY_ID'  => $companyId,
            'BRANCH_ID'   => $branchId,
            'BUILDING_ID' => $buildingId
        ]);
    }

    // 4. Load Properties if all IDs given
    if ($companyId && $branchId && $buildingId && $floorId) {
        $dropdowns['properties'] = $spService->execute('RMASTER.GET_PROPERTIES_BY_COMPANY_BRANCH_BUILDING_FLOOR', [
            'COMPANY_ID'  => $companyId,
            'BRANCH_ID'   => $branchId,
            'BUILDING_ID' => $buildingId,
            'FLOOR_ID'    => $floorId
        ]);
    }

    return response()->json([
        'status' => 'success',
        'data'   => $dropdowns
    ]);
} catch (\Exception $e) {
    return response()->json([
        'status'  => 'error',
        'message' => $e->getMessage()
    ], 500);
}


}


public function loadDropdownByFieldId(DynamicStoredProcedureService $spService)
{
    try {
        $fieldId = request()->input('id');

        if (!$fieldId) {
            return response()->json([
                'status'  => 'error',
                'message' => 'FIELD_ID is required.'
            ], 400);
        }

        // Call the stored procedure
        $dropdownData = $spService->execute('RMASTER.SP_GET_COMMON_DROPDOWN_BY_FIELD_ID', [
            'FIELD_ID' => $fieldId
        ]);

        return response()->json([
            'status' => 'success',
            'data'   => $dropdownData
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function index(DynamicStoredProcedureService $spService)
    {
        $spName = 'RMASTER.SHOW_BRANCH_MASTER';

        try {
            $branch = $spService->execute($spName, [], request()->ip(), auth()->user()->name ?? 'admin');

            $companies = DB::select('SELECT COMPANY_ID, COMPANY_NAME FROM [RENTAL].[RMASTER].[COMPANY_MASTER]');

            return view('branch.branch', [
                'branch'     => $branch,
                'companies'  => $companies,
                'createdBy'  => auth()->user()->name ?? 'Admin',
                'macAddress' => request()->ip(),
                'message'    => session('message'),
                'status'     => session('status')
            ]);
        } catch (\Exception $e) {
            return redirect()->route('branch')->with([
                'status' => 'Error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function save(SaveBranchRequest $request, DynamicStoredProcedureService $spService)
    {
        $spName = 'RMASTER.SAVE_BRANCH_MASTER';

        $params = [
            'BRANCH_ID'            => null,
            'COMPANY_ID'           => $request->company_id,
            'BRANCH_NAME'          => $request->branch_name,
            'BRANCH_ADDRESS'       => $request->branch_address,
            'REMARKS'              => $request->remarks,
            'STATUS_MASTER'        => $request->status_master,
            'CREATED_BY'           => auth()->user()->name ?? 'admin',
            'CREATED_MAC_ADDRESS'  => $request->ip(),
        ];

        try {
            $result = $spService->execute($spName, $params, $request->ip(), auth()->user()->name ?? 'admin');
            $response = $result[0] ?? null;

            return redirect()->route('branch')->with([
                'status'  => $response->Column1 ?? 'Success',
                'message' => $response->Column2 ?? 'Branch saved successfully'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('branch')->with([
                'status'  => 'Error',
                'message' => $e->getMessage()
            ]);
        }
    }

     public function SP_INSERT_PROPERTY_SELECTION(Request $request,DynamicStoredProcedureService $spService)
    {
        $spName = 'RMASTER.SP_INSERT_PROPERTY_SELECTION';

        $params = [
            'FLOOR_ID'            => $request->floor_id,
             'BUILDING_ID'            => $request->building_id,
            'COMPANY_ID'           => $request->company_id,
            'BRANCH_ID'          => $request->branch_id,
            'PROPERTY_ID'       => $request->property_id,
            'STATUS_ID'        => $request->status_id,
            'CURRENCY_ID'        => $request->currency_id,
            'PAYMENT_METHOD_ID'        => $request->payment_method_id,
            'CREATED_BY'           => auth()->user()->name ?? 'admin',
            'CREATED_IP'  => $request->ip(),
        ];

        try {
            $result = $spService->execute($spName, $params, $request->ip(), auth()->user()->name ?? 'admin');
            $response = $result[0] ?? null;

            return redirect()->route('branch')->with([
                'status'  => $response->Column1 ?? 'Success',
                'message' => $response->Column2 ?? 'Branch saved successfully'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('branch')->with([
                'status'  => 'Error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(UpdateBranchRequest $request, DynamicStoredProcedureService $spService)
    {
        $spName = 'RMASTER.UPDATE_BRANCH_MASTER';

        $params = [
            'BRANCH_ID'            => $request->id,
            'COMPANY_ID'           => $request->company_id,
            'BRANCH_NAME'          => $request->branch_name,
            'BRANCH_ADDRESS'       => $request->branch_address,
            'REMARKS'              => $request->remarks,
            'STATUS_MASTER'        => $request->status_master,
            'USER'                 => auth()->user()->name ?? 'admin',
            'UPDATED_MAC_ADDRESS'  => $request->ip(),
        ];

        try {
            $result = $spService->execute($spName, $params, $request->ip(), auth()->user()->name ?? 'admin');
            $response = $result[0] ?? null;

            return redirect()->route('branch')->with([
                'status'  => $response->Column1 ?? 'Success',
                'message' => $response->Column2 ?? 'Branch updated successfully'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('branch')->with([
                'status'  => 'Error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(DeleteBranchRequest $request, DynamicStoredProcedureService $spService)
    {
        $spName = 'RMASTER.DELETE_BRANCH_MASTER';

        $params = [
            'BRANCH_ID'   => $request->id,
            'USER'        => auth()->user()->name ?? 'admin',
            'MAC_ADDRESS' => $request->ip(),
        ];

        try {
            $result = $spService->execute($spName, $params, $request->ip(), auth()->user()->name ?? 'admin');
            $response = $result[0] ?? null;

            return redirect()->route('branch')->with([
                'status'  => $response->Column1 ?? 'Success',
                'message' => $response->Column2 ?? 'Branch deleted successfully'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('branch')->with([
                'status'  => 'Error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
