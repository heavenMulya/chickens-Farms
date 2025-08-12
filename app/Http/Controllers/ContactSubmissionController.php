<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ContactSubmissionController extends Controller
{
    /**
     * Display a listing of contact submissions with pagination
     */
    public function index(Request $request): JsonResponse
    {
        $query = ContactSubmission::query();
        
        // Apply filters
        $this->applyFilters($query, $request);
        
        // Paginate results
        $perPage = $request->get('per_page', 10);
        $submissions = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json([
            'status' => 'success',
            'data' => $submissions
        ]);
    }

    /**
     * Search contact submissions with filters
     */
    public function search(Request $request): JsonResponse
    {
        $query = ContactSubmission::query();
        
        // Apply filters
        $this->applyFilters($query, $request);
        
        // Paginate results
        $perPage = $request->get('per_page', 10);
        $submissions = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json([
            'status' => 'success',
            'data' => $submissions
        ]);
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, Request $request)
    {
        // Search filter - search in name, email, and message
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }
        
        // Subject filter
        if ($request->has('subject') && !empty($request->subject)) {
            $query->where('subject', $request->subject);
        }
        
        // Date filter
        if ($request->has('date_filter') && !empty($request->date_filter)) {
            $dateFilter = $request->date_filter;
            switch ($dateFilter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }
    }

    /**
     * Store a new contact submission
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => ['required', Rule::in(array_keys(ContactSubmission::$subjects))],
            'message' => 'required|string|max:5000'
        ]);

        $submission = ContactSubmission::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Contact submission created successfully',
            'data' => $submission
        ], 201);
    }

    /**
     * Display a specific contact submission
     */
    public function show(ContactSubmission $contactSubmission): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $contactSubmission
        ]);
    }

    /**
     * Update a contact submission
     */
    public function update(Request $request, ContactSubmission $contactSubmission): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:100',
            'last_name' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => ['sometimes', 'required', Rule::in(array_keys(ContactSubmission::$subjects))],
            'message' => 'sometimes|required|string|max:5000'
        ]);

        $contactSubmission->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Contact submission updated successfully',
            'data' => $contactSubmission->fresh()
        ]);
    }

    /**
     * Remove a contact submission
     */
    public function destroy(ContactSubmission $contactSubmission): JsonResponse
    {
        $contactSubmission->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Contact submission deleted successfully'
        ]);
    }

    /**
     * Get subject options
     */
    public function subjects(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => ContactSubmission::$subjects
        ]);
    }

    /**
     * Bulk delete contact submissions
     */
    public function bulkDestroy(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:contact_submissions,id'
        ]);

        $deletedCount = ContactSubmission::whereIn('id', $validated['ids'])->delete();

        return response()->json([
            'status' => 'success',
            'message' => "Successfully deleted {$deletedCount} contact submissions"
        ]);
    }

    /**
     * Get statistics for dashboard
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_submissions' => ContactSubmission::count(),
            'today_submissions' => ContactSubmission::whereDate('created_at', Carbon::today())->count(),
            'this_week_submissions' => ContactSubmission::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(),
            'this_month_submissions' => ContactSubmission::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
            'by_subject' => ContactSubmission::selectRaw('subject, COUNT(*) as count')
                ->groupBy('subject')
                ->pluck('count', 'subject')
                ->toArray()
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }

    /**
     * Export contact submissions to CSV
     */
    public function export(Request $request): JsonResponse
    {
        $query = ContactSubmission::query();
        $this->applyFilters($query, $request);
        
        $submissions = $query->orderBy('created_at', 'desc')->get();
        
        $csvData = [];
        $csvData[] = ['First Name', 'Last Name', 'Email', 'Phone', 'Subject', 'Message', 'Created At'];
        
        foreach ($submissions as $submission) {
            $csvData[] = [
                $submission->first_name,
                $submission->last_name,
                $submission->email,
                $submission->phone ?? '',
                ContactSubmission::$subjects[$submission->subject] ?? $submission->subject,
                $submission->message,
                $submission->created_at->format('Y-m-d H:i:s')
            ];
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $csvData,
            'filename' => 'contact_submissions_' . now()->format('Y_m_d_H_i_s') . '.csv'
        ]);
    }
}

// Routes for api.php
/*
use App\Http\Controllers\ContactSubmissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('contact-submissions')->group(function () {
    Route::get('/', [ContactSubmissionController::class, 'index']);
    Route::get('/search', [ContactSubmissionController::class, 'search']);
    Route::get('/statistics', [ContactSubmissionController::class, 'statistics']);
    Route::get('/export', [ContactSubmissionController::class, 'export']);
    Route::post('/', [ContactSubmissionController::class, 'store']);
    Route::get('/subjects', [ContactSubmissionController::class, 'subjects']);
    Route::get('/{contactSubmission}', [ContactSubmissionController::class, 'show']);
    Route::put('/{contactSubmission}', [ContactSubmissionController::class, 'update']);
    Route::patch('/{contactSubmission}', [ContactSubmissionController::class, 'update']);
    Route::delete('/{contactSubmission}', [ContactSubmissionController::class, 'destroy']);
    Route::delete('/', [ContactSubmissionController::class, 'bulkDestroy']);
});
*/