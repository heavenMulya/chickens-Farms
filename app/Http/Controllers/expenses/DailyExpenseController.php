<?php

namespace App\Http\Controllers\expenses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\daily_expenses;
use Illuminate\Support\Carbon;

class DailyExpenseController extends Controller
{
    public function index()
    {
        $expenses = daily_expenses::orderBy('expense_date', 'desc')->paginate(10);
        
            // Add fallback value for display
    $expenses->getCollection()->transform(function ($expense) {
        $expense->batch_display = $expense->batch_code ?: 'No Batch / General Expense';
        return $expense;
    });
        
        return response()->json([
            'success' => true,
            'data' => $expenses
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'expense_type' => 'required|string',
            'batch_code' => 'nullable|string|exists:chicken_batches,batch_code',
            'amount' => 'required|numeric|min:0',
          //  'expense_date' => 'required|date',
            'remarks' => 'nullable|string'
        ]);
 $validated['expense_date'] = Carbon::today();
        $expense = daily_expenses::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Expense recorded successfully.',
            'data' => $expense
        ], 201);
    }

    public function show($id)
    {
        $expense = daily_expenses::findOrFail($id);
        return response()->json(['data' => $expense]);
    }

    public function update(Request $request, $id)
    {
        $expense = daily_expenses::findOrFail($id);

        $validated = $request->validate([
            'expense_type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            //'expense_date' => 'required|date',
            'batch_code' => 'nullable|string|exists:chicken_batches,batch_code',
            'remarks' => 'nullable|string'
        ]);
 $validated['expense_date'] = Carbon::today();
        $expense->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Expense updated successfully.',
            'data' => $expense
        ]);
    }

    public function destroy($id)
    {
        $expense = daily_expenses::findOrFail($id);
        $expense->delete();

        return response()->json([
            'success' => true,
            'message' => 'Expense deleted successfully.'
        ]);
    }

    public function searching(Request $request)
{
    $perPage = $request->input('per_page', 10);
    $search = $request->input('search');

    $query = daily_expenses::query();

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('expense_type', 'like', "%{$search}%")
              ->orWhere('batch_code', 'like', "%{$search}%");
        });
    }

    $expenses = $query->orderBy('created_at', 'desc')->paginate($perPage);

    return response()->json([
        'success' => true,
        'data' => $expenses
    ]);
}

}
