<?php

namespace App\Providers;

use Braintree\Gateway;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        
        $this->app->singleton(Gateway::class, function($app) {
            return new Gateway([
                'environment' => 'sandbox',
                'merchantId' => '8qxh27bqnbx8vsps',
                'publicKey' => 'bwxgmtz83y2dg9gw',
                'privateKey' => '097a4e009a185f2fb36aa26429435d18'
            ]);
        });
    }
}
