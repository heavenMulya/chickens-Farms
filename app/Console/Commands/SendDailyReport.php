<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Mail\DailyReport;
use Illuminate\Support\Facades\Mail;
use App\Models\User; 

class SendDailyReport extends Command
{

     protected $signature = 'email:send-daily';
    protected $description = 'Send the daily report email';

    public function handle()
    {
        $data = ['message' => 'This is your scheduled daily report.'];

        User::chunk(100, function($users) use ($data) {
            foreach ($users as $user) {
                Mail::to('heavenlyamuya959@gmail.com')->send(new DailyReport($data));
            }
        });

        $this->info('Daily emails sent.');
    }
}



