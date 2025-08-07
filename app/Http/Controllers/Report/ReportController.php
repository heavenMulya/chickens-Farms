<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChickenEntry;
use App\Models\ChickenBatch;
use App\Models\daily_expenses;
use App\Models\Egg;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Sales Reports
 public function salesReport(Request $request)
{
    $period = $request->input('period', 'daily');
    $from = $request->input('from');
    $to = $request->input('to');

    $chickenSales = ChickenEntry::with('batch')
        ->when(true, function ($query) use ($period, $from, $to) {
            return $this->applyPeriod($query, 'entry_date', $period, $from, $to);
        })
        ->get()
        ->map(fn($entry) => [
            'type' => 'Chicken',
            'batch_code' => $entry->batch->batch_code ?? 'N/A',
            'entry_date' => $entry->entry_date,
            'sold' => $entry->sold
        ]);

    $eggSales = Egg::with('batch')
        ->when(true, function ($query) use ($period, $from, $to) {
            return $this->applyPeriod($query, 'created_at', $period, $from, $to);
        })
        ->get()
        ->map(fn($egg) => [
            'type' => 'Egg',
            'batch_code' => $egg->batch?->batch_code ?? 'N/A',
            'entry_date' => $egg->created_at->toDateString(),
            'sold' => $egg->sold_eggs
        ]);

    $finalSales = $chickenSales->merge($eggSales)
        ->groupBy(fn($item) => $item['type'] . '-' . $item['batch_code'])
        ->map(function ($items) {
            $first = $items->first();
            return [
                'type' => $first['type'],
                'batch_code' => $first['batch_code'],
                'sold' => $items->sum('sold'),
            ];
        })->values();

    return response()->json(['data' => $finalSales]);
}



public function eggsProductionReport(Request $request)
{
    $period = $request->input('period', 'daily');
    $from = $request->input('from');
    $to = $request->input('to');

    $eggs = Egg::with('batch')
        ->when(true, fn($query) => $this->applyPeriod($query, 'created_at', $period, $from, $to))
        ->get();

    $data = $eggs->map(function ($egg) {
        $broken = $egg->broken_eggs ?? 0;
        $total = $egg->total_eggs ?? 0;
        $good = $total - $broken;

        return [
            'entry_date' => $egg->created_at->toDateString(),
            'batch_code' => $egg->batch?->batch_code ?? 'N/A',
            'total_eggs' => $total,
            'good_eggs' => $good,
            'broken_eggs' => $broken
        ];
    });

    return response()->json(['data' => $data]);
}


public function chickenManagementReport(Request $request)
{
    $period = $request->input('period', 'daily');
    $from = $request->input('from');
    $to = $request->input('to');

    $chickenEntries = ChickenEntry::with('batch')
        ->when(true, fn($query) => $this->applyPeriod($query, 'entry_date', $period, $from, $to))
        ->get();

    $data = $chickenEntries->map(fn($entry) => [
        'entry_date' => $entry->entry_date,
        'batch_code' => $entry->batch?->batch_code ?? 'N/A',
        'slaughtered' => $entry->slaughtered ?? 0,
        'dead' => $entry->dead ?? 0
    ]);

    return response()->json(['data' => $data]);
}



public function businessSummary(Request $request)
{
    $filter = $request->query('filter'); // daily, weekly, monthly
    $from = $request->query('from');
    $to = $request->query('to');

    $eggQuery = Egg::query();
    $chickenEntryQuery = ChickenEntry::query();
    $chickenBatchQuery = ChickenBatch::query();
    $expenseQuery = daily_expenses::query();

    // Apply filters
    if ($filter === 'daily') {
        $eggQuery->whereDate('created_at', now());
        $chickenEntryQuery->whereDate('created_at', now());
        $chickenBatchQuery->whereDate('created_at', now());
        $expenseQuery->whereDate('created_at', now());
    } elseif ($filter === 'weekly') {
        $eggQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        $chickenEntryQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        $chickenBatchQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        $expenseQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    } elseif ($filter === 'monthly') {
        $eggQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        $chickenEntryQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        $chickenBatchQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        $expenseQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
    } elseif ($from && $to) {
        $eggQuery->whereBetween('created_at', [$from, $to]);
        $chickenEntryQuery->whereBetween('created_at', [$from, $to]);
        $chickenBatchQuery->whereBetween('created_at', [$from, $to]);
        $expenseQuery->whereBetween('created_at', [$from, $to]);
    }

    // Then calculate as before
    $totalEggs = $eggQuery->sum('total_eggs');
    $remainingEggs = $eggQuery->sum('remaining_eggs');
    $soldEggs = $eggQuery->sum('sold_eggs');
    $brokenEggs = $eggQuery->sum('broken_eggs');
    $goodEggs = $totalEggs - $brokenEggs;

    $totalChickens = $chickenBatchQuery->sum('quantity');
    $soldChickens = $chickenEntryQuery->sum('sold');
    $slaughteredChickens = $chickenEntryQuery->sum('slaughtered');
    $deadChickens = $chickenEntryQuery->sum('dead');

    $inventory = [
        'eggs' => $remainingEggs,
        'chickens' => $totalChickens - $soldChickens - $slaughteredChickens - $deadChickens
    ];

    $revenue = [
        'chickens' => $soldChickens * 10,
        'eggs' => $soldEggs * 0.5
    ];

    $expenses = $expenseQuery->sum('amount');
    $profit = ($revenue['chickens'] + $revenue['eggs']) - $expenses;

    $alerts = [];
    if ($inventory['eggs'] < 100) $alerts[] = 'Egg stock low!';
    if ($inventory['chickens'] < 50) $alerts[] = 'Chicken stock low!';

    return response()->json([
        'eggs' => [
            'total_eggs' => $totalEggs,
            'remaining_eggs' => $remainingEggs,
            'sold_eggs' => $soldEggs,
            'broken_eggs' => $brokenEggs,
            'good_eggs' => $goodEggs,
        ],
        'chickens' => [
            'total_chickens' => $totalChickens,
            'sold_chickens' => $soldChickens,
            'slaughtered_chickens' => $slaughteredChickens,
            'dead_chickens' => $deadChickens,
        ],
        'inventory' => $inventory,
        'revenue' => $revenue,
        'expenses' => $expenses,
        'profit' => $profit,
        'alerts' => $alerts
    ]);
}


public function batchWiseSummary()
{
    $batches = ChickenBatch::with(['entries', 'eggs'])->get();

    $summary = $batches->map(function ($batch) {
        $totalEggs = $batch->eggs->sum('total_eggs');
        $soldEggs = $batch->eggs->sum('sold_eggs');
        $brokenEggs = $batch->eggs->sum('broken_eggs');
        $remainingEggs = $batch->eggs->sum('remaining_eggs');
        $goodEggs = $totalEggs;

        $soldChickens = $batch->entries->sum('sold');
        $slaughteredChickens = $batch->entries->sum('slaughtered');
        $deadChickens = $batch->entries->sum('dead');
        $total=$soldChickens+$slaughteredChickens+$deadChickens;

        return [
            'batch_code' => $batch->batch_code,
            'eggs' => [
                'total_eggs' => $totalEggs,
                'sold_eggs' => $soldEggs,
                'broken_eggs' => $brokenEggs,
                'remaining_eggs' => $remainingEggs,
                'good_eggs' => $goodEggs,
            ],
            'chickens' => [
                'total_chickens' => $total,
                'sold_chickens' => $soldChickens,
                'slaughtered_chickens' => $slaughteredChickens,
                'dead_chickens' => $deadChickens,
            ]
        ];
    });

    return response()->json([
        'batch_wise_summary' => $summary
    ]);
}


    // Profit Calculation Report
   public function profitReport(Request $request)
{
    $period = $request->input('period', 'monthly');
    $from = $request->input('from');
    $to = $request->input('to');

    $chickenRevenue = ChickenEntry::when(true, fn($query) => $this->applyPeriod($query, 'entry_date', $period, $from, $to))
        ->sum('sold') * 10;

    $eggRevenue = Egg::when(true, fn($query) => $this->applyPeriod($query, 'created_at', $period, $from, $to))
        ->sum('sold_eggs') * 0.5;

    $expenses = daily_expenses::when(true, fn($query) => $this->applyPeriod($query, 'expense_date', $period, $from, $to))
        ->sum('amount');

    $profit = ($chickenRevenue + $eggRevenue) - $expenses;

    return response()->json([
        'period' => $period,
        'from' => $from,
        'to' => $to,
        'revenue' => ['chickens' => $chickenRevenue, 'eggs' => $eggRevenue],
        'expenses' => $expenses,
        'profit' => $profit
    ]);
}

    // Helper for period filtering
   private function applyPeriod($query, $column, $period = null, $from = null, $to = null)
{
    $now = Carbon::now();

    if ($from && $to) {
        return $query->whereBetween($column, [$from, $to]);
    }

    return match ($period) {
        'daily' => $query->whereDate($column, $now->toDateString()),
        'weekly' => $query->whereBetween($column, [
            (clone $now)->startOfWeek(),
            (clone $now)->endOfWeek(),
        ]),
        'monthly' => $query->whereMonth($column, $now->month)
                           ->whereYear($column, $now->year),
        default => $query,
    };
}

}