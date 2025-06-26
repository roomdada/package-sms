<?php

namespace Room\Sms;

use Illuminate\Support\ServiceProvider;
use Room\Sms\SmsClient;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SmsClient::class, function ($app) {
            return new SmsClient([
                'token' => config('letexto.token'),
                'base_url' => config('letexto.base_url'),
                'timeout' => config('letexto.timeout'),
            ]);
        });

        $this->app->alias(SmsClient::class, 'letexto.sms');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/letexto.php' => config_path('letexto.php'),
            ], 'letexto-config');
        }
    }
}
