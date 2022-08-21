<?php

namespace PluckyPenguin\LaravelNordigen;

use Illuminate\Support\ServiceProvider;
use Nordigen\NordigenPHP\API\NordigenClient;

class NordigenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'nordigen');

        $this->app->bind(NordigenClient::class, function () {
            return $this->getNordigenClient();
        });

        $this->app->bind('nordigenclient', function ($app) {
            return $this->getNordigenClient();
        });
    }

    /**
     * @return NordigenClient
     */
    private function getNordigenClient(): NordigenClient
    {
        return new NordigenClient(config('nordigen.secret_id'), config('nordigen.secret_key'));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/config.php' => config_path('nordigen.php'),
            ], 'config');
        }
    }
}
