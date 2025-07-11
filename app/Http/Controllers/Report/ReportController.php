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

    // Get Chicken Sales Details
    $chickenSales = ChickenEntry::with('batch')
        ->when($period, function ($query) use ($period) {
            return $this->applyPeriod($query, 'entry_date', $period);
        })
        ->get()
        ->map(function ($entry) {
            return [
                'type' => 'Chicken',
                'batch_code' => $entry->batch->batch_code ?? 'N/A',
                'entry_date' => $entry->entry_date,
                'sold' => $entry->sold
            ];
        });

    // Get Egg Sales Details
    $eggSales = Egg::with('batch')
        ->when($period, function ($query) use ($period) {
            return $this->applyPeriod($query, 'created_at', $period);
        })
        ->get()
        ->map(function ($egg) {
            return [
                'type' => 'Egg',
                'batch_code' => $egg->batch?->batch_code ?? 'N/A',
                'entry_date' => $egg->created_at->toDateString(),
                'sold' => $egg->sold_eggs
            ];
        });

    // Merge and group by type + batch_code
    $merged = $chickenSales->merge($eggSales);

    $grouped = $merged->groupBy(function ($item) {
        return $item['type'] . '-' . $item['batch_code'];
    });

    $finalSales = $grouped->map(function ($items) {
        $first = $items->first();
        return [
            'type' => $first['type'],
            'batch_code' => $first['batch_code'],
            'sold' => $items->sum('sold'),
        ];
    })->values();

    return response()->json([
        'data' => $finalSales
    ]);
}


public function eggsProductionReport(Request $request)
{
    $period = $request->input('period', 'daily');

    $eggs = Egg::with('batch')
        ->when($period, function ($query) use ($period) {
            return $this->applyPeriod($query, 'created_at', $period);
        })
        ->get();

    $data = $eggs->map(function ($egg) {
        $broken = $egg->broken_eggs ?? 0;
        $total = $egg->total_eggs ?? 0;
        $good = $total - $broken;

        return [
            'entry_date'   => $egg->created_at->toDateString(),
            'batch_code'   => $egg->batch?->batch_code ?? 'N/A',
            'total_eggs'   => $total,
            'good_eggs'    => $good,
            'broken_eggs'  => $broken
        ];
    });

    return response()->json([
        'data' => $data
    ]);
}


public function chickenManagementReport(Request $request)
{
    $period = $request->input('period', 'daily');

    $chickenEntries = ChickenEntry::with('batch')
        ->when($period, function ($query) use ($period) {
            return $this->applyPeriod($query, 'entry_date', $period);
        })
        ->get();

    $data = $chickenEntries->map(function ($entry) {
        return [
            'entry_date'  => $entry->entry_date,
            'batch_code'  => $entry->batch?->batch_code ?? 'N/A',
            'slaughtered' => $entry->slaughtered ?? 0,
            'dead'        => $entry->dead ?? 0
        ];
    });

    return response()->json([
        'data' => $data
    ]);
}


public function businessSummary()
{
    $totalEggs = Egg::sum('total_eggs');
    $remainingEggs = Egg::sum('remaining_eggs');
    $soldEggs = Egg::sum('sold_eggs');
    $brokenEggs = Egg::sum('broken_eggs');
    $goodEggs = $totalEggs - $brokenEggs;

    $totalChickens = ChickenBatch::sum('quantity');
    $soldChickens = ChickenEntry::sum('sold');
    $slaughteredChickens = ChickenEntry::sum('slaughtered');
    $deadChickens = ChickenEntry::sum('dead');

    $inventory = [
        'eggs' => $remainingEggs,
        'chickens' => $totalChickens - $soldChickens - $slaughteredChickens - $deadChickens
    ];

    $revenue = [
        'chickens' => $soldChickens * 10, // $10 per chicken
        'eggs' => $soldEggs * 0.5         // $0.5 per egg
    ];

    $expenses = daily_expenses::sum('amount');
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
        $goodEggs = $totalEggs - $brokenEggs;

        $soldChickens = $batch->entries->sum('sold');
        $slaughteredChickens = $batch->entries->sum('slaughtered');
        $deadChickens = $batch->entries->sum('dead');

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
                'total_chickens' => $batch->quantity,
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
        
        $revenue = [
            'chickens' => ChickenEntry::when($period, function ($query) use ($period) {
                return $this->applyPeriod($query, 'entry_date', $period);
            })->sum('sold') * 10, // $10 per chicken
            
            'eggs' => Egg::when($period, function ($query) use ($period) {
                return $this->applyPeriod($query, 'created_at', $period);
            })->sum('sold_eggs') * 0.5 // $0.5 per egg
        ];
        
        $expenses = daily_expenses::when($period, function ($query) use ($period) {
            return $this->applyPeriod($query, 'expense_date', $period);
        })->sum('amount');
        
        $profit = ($revenue['chickens'] + $revenue['eggs']) - $expenses;

        return response()->json([
            'period' => $period,
            'revenue' => $revenue,
            'expenses' => $expenses,
            'profit' => $profit
        ]);
    }

    // Helper for period filtering
    private function applyPeriod($query, $column, $period)
    {
        $now = Carbon::now();
        
        return match ($period) {
            'daily' => $query->whereDate($column, $now->toDateString()),
            'weekly' => $query->whereBetween($column, [
            (clone $now)->startOfWeek(),
            (clone $now)->endOfWeek(),
        ]),

        'monthly' => $query->whereMonth($column, $now->month)
                           ->whereYear($column, $now->year),
        };
    }
}