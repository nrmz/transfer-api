<?php
namespace App\Http\Notification\Interface;

interface SendSmsInterface
{
    public function send(string $to, string $message);
}
