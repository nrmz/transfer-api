<?php
namespace App\Http\Notification;

use App\Http\Notification\Interface\SendSmsInterface;
use Illuminate\Support\Facades\Log;

class SmsirService implements SendSmsInterface
{

    public function send(string $to, string $message)
    {
        Log::info('sms send from smsir to ' . $to . ' with message ' . $message);
        return true;
    }
}
