<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;
use App\Models\User;
Use \Carbon\Carbon;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reminder = Document::with('user')->where('is_reminder','yes')->get();

        foreach ($reminder as $key => $value) {
            if($value['premium_payment_duration']=="1_month") {
                $date = $value['premium_payment_date'];
                $year = Carbon::parse($value['premium_payment_date'])->year;
                $now = Carbon::now();
                $diff = $date->diffInDays($now);
                if($diff>30 && $diff<=31) {
                    $details = [
                        'title' => 'hi,'.$value->user->name,
                        'body' => 'Thanks for using our service for the past year -'.$year.' – we love having you as our customer. Your subscription will expire in days, so we thought we’d check in.'
                    ];

                    \Mail::to($value->user->email)->send(new \App\Mail\ReminderEmail($details));
                }
            }elseif ($value['premium_payment_duration']=="3_month") {
                $date = $value['premium_payment_date'];
                $year = Carbon::parse($value['premium_payment_date'])->year;
                $now = Carbon::now();
                $diff = $date->diffInDays($now);
                if($diff>90 && $diff<=92) {
                    $details = [
                        'title' => 'hi,'.$value->user->name,
                        'body' => 'Thanks for using our service for the past year -'.$year.' – we love having you as our customer. Your subscription will expire in  days, so we thought we’d check in.'
                    ];

                    \Mail::to($value->user->email)->send(new \App\Mail\ReminderEmail($details));
                }
            }elseif ($value['premium_payment_duration']=="6_month") {
                $date = $value['premium_payment_date'];
                $year = Carbon::parse($value['premium_payment_date'])->year;
                $now = Carbon::now();
                $diff = $date->diffInDays($now);
                if($diff>=180 && $diff<=184) {
                    $details = [
                        'title' => 'hi,'.$value->user->name,
                        'body' => 'Thanks for using our service for the past year -'.$year.' – we love having you as our customer. Your subscription will expire in days, so we thought we’d check in.'
                    ];

                    \Mail::to($value->user->email)->send(new \App\Mail\ReminderEmail($details));
                }
            }elseif ($value['premium_payment_duration']=="yearly") {
                $date = $value['premium_payment_date'];
                $year = Carbon::parse($value['premium_payment_date'])->year;
                $now = Carbon::now();
                $diff = $date->diffInDays($now);
                if($diff>365 && $diff<=366) {
                    $details = [
                        'title' => 'hi,'.$value->user->name,
                        'body' => 'Thanks for using our service for the past year -'.$year.' – we love having you as our customer. Your subscription will expire in  days, so we thought we’d check in.'
                    ];

                    \Mail::to($value->user->email)->send(new \App\Mail\ReminderEmail($details));
                }
            }
        }
    }
}
