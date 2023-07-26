<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Document;
use Notification;
use App\Notifications\ReminderNotification;
Use \Carbon\Carbon;


class NotificationController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index()
    {
        $userSchema->notify(new ReminderNotification($offerData));
    }
    
    public function sendOfferNotification() {

        $userSchema = Document::with('user')->where('is_reminder','yes')->get();
        $user = User::first();
        foreach ($userSchema as $key => $value) {
            if($value['premium_payment_duration']=="1_month") {
                $date = $value['premium_payment_date'];
                $year = Carbon::parse($value['premium_payment_date'])->year;
                $now = Carbon::now();
                $diff = $date->diffInDays($now);
                if($diff>30 && $diff<=31) {
                    $offerData = [
                        'greeting' => 'Hi,'.$value->user->name,
                        'body' => 'Thanks for using our service for the past year -'.$year.' – we love having you as our customer. Your subscription will expire in  days, so we thought we’d check in.Thanks for using our service for the past year -'.$year.' – we love having you as our customer. Your subscription will expire in  days, so we thought we’d check in.',
                        'thanks' => 'Thank you for using Our Service',
                        'actionText' => 'View My Site',
                        'actionURL' => url('/'),
                    ];
                    Notification::send($user, new ReminderNotification($offerData));
                    Notification::route('mail', $value->user->email)
                    ->notify(new ReminderNotification($offerData));
                }
            }elseif ($value['premium_payment_duration']=="3_month") {
                $date = $value['premium_payment_date'];
                $year = Carbon::parse($value['premium_payment_date'])->year;
                $now = Carbon::now();
                $diff = $date->diffInDays($now);
                if($diff>90 && $diff<=92) {
                    $offerData = [
                        'greeting' => 'Hi,'.$value->user->name,
                        'body' => 'Thanks for using our service for the past year -'.$year.' – we love having you as our customer. Your subscription will expire in  days, so we thought we’d check in.Thanks for using our service for the past year -'.$year.' – we love having you as our customer. Your subscription will expire in  days, so we thought we’d check in',
                        'thanks' => 'Thank you for using Our Service',
                        'actionText' => 'View My Site',
                        'actionURL' => url('/'),
                    ];
                    Notification::send($user, new ReminderNotification($offerData));
                    Notification::route('mail', $value->user->email)
                    ->notify(new ReminderNotification($offerData));
                }
            }elseif ($value['premium_payment_duration']=="6_month") {
                $date = $value['premium_payment_date'];
                $year = Carbon::parse($value['premium_payment_date'])->year;
                $now = Carbon::now();
                $diff = $date->diffInDays($now);
                if($diff>=180 && $diff<=184) {
                    $offerData = [
                        'greeting' => 'Hi,'.$value->user->name,
                        'body' => 'Thanks for using our service for the past year -'.$year.' – we love having you as our customer. Your subscription will expire in  days, so we thought we’d check in.Thanks for using our service for the past year -'.$year.' – we love having you as our customer. Your subscription will expire in  days, so we thought we’d check in.',
                        'thanks' => 'Thank you for using Our Service',
                        'actionText' => 'View My Site',
                        'actionURL' => url('/'),
                    ];
                    Notification::send($user, new ReminderNotification($offerData));
                    Notification::route('mail', $value->user->email)
                ->notify(new ReminderNotification($offerData));

                    
                }
            }elseif ($value['premium_payment_duration']=="yearly") {
                $date = $value['premium_payment_date'];
                $year = Carbon::parse($value['premium_payment_date'])->year;
                $now = Carbon::now();
                $diff = $date->diffInDays($now);
                if($diff>365 && $diff<=366) {
                    $offerData = [
                        'greeting' => 'Hi,'.$value->user->name,
                        'body' => 'Thanks for using our service for the past year -'.$year.' – we love having you as our customer. Your subscription will expire in  days, so we thought we’d check in.Thanks for using our service for the past year -'.$year.' – we love having you as our customer. Your subscription will expire in  days, so we thought we’d check in.',
                        'thanks' => 'Thank you for using Our Service',
                        'actionText' => 'View My Site',
                        'actionURL' => url('/'),
                    ];
                    Notification::send($user, new ReminderNotification($offerData));
                    Notification::route('mail', $value->user->email)
                    ->notify(new ReminderNotification($offerData));
                }
                
            }
        }        
    }
}