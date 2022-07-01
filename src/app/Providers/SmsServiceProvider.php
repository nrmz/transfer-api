<?php

namespace App\Providers;

use App\Http\Notification\Interface\SendSmsInterface;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{

    const SMS_SERVICE_PROVIDERS =[
        'kavenegar' => 'App\Http\Notification\KavenegarService',
        'smsir' => 'App\Http\Notification\SmsirService'
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SendSmsInterface::class, function () {
            if(self::SMS_SERVICE_PROVIDERS[config('services.sms-service-provider.name')]){
                return resolve(self::SMS_SERVICE_PROVIDERS[config('services.sms-service-provider.name')]);
            }
            throw new \Exception('The exchange rates driver is invalid.');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
