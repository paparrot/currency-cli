<?php

namespace App\Providers;

use App\Contracts\CurrencyRepository;
use App\Services\CBR;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(CurrencyRepository::class, function () {
            return new CBR();
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
