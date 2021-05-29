<?php

namespace App\Providers;

use App\Http\Clases\PlaceToPay;
use Illuminate\Support\ServiceProvider;

class PaymentGatewayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            App\Http\Interfaces\PaymentGatewayInterface::class,
            PlaceToPay::class
        );
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
