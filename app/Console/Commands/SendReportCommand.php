<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportMail;
use Illuminate\Http\Request;

class SendReportCommand extends Command
{
    protected $signature = 'report:send {type=daily}';
    protected $description = 'Send daily, weekly, monthly reports and batch summary via email';

   public function handle()
{
    $type = $this->argument('type'); // daily, weekly, monthly
    $this->info("Preparing {$type} report...");

    // Build request for business summary
    
    $req = Request::create('/', 'GET', ['filter' => $type]);
    $controller = app(\App\Http\Controllers\Report\ReportController::class);

    // Get business summary data
    $response = $controller->businessSummary($req);
    $businessReportData = json_decode($response->getContent(), true);

    $recipient = env('REPORT_EMAIL', 'heavenlyamuya959@gmail.com');

    // Send business summary email
    Mail::to($recipient)->send(new ReportMail($businessReportData, $type, 'business'));
    $this->info("{$type} business summary emailed to {$recipient}");

    // Only send batch-wise summary if daily
    if ($type === 'daily') {
        // Call batchWiseSummary() method (returns JsonResponse)
        $batchResponse = $controller->batchWiseSummary();
        $batchReportData = json_decode($batchResponse->getContent(), true);

        Mail::to($recipient)->send(new ReportMail($batchReportData, $type, 'batch'));
        $this->info("{$type} batch-wise summary emailed to {$recipient}");
    }
}

}
