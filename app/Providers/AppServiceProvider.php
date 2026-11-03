<?php

namespace App\Providers;

use App\Servicios\ExchangeRateAPI;
use App\Servicios\MockServicioPago;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('App\Servicios\ITipoCambio', ExchangeRateAPI::class);
        $this->app->bind('App\Servicios\IServicioPago', MockServicioPago::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
