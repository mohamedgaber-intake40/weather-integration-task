<?php

namespace App\Providers;

use App\Services\Weather\Contracts\WeatherService;
use App\Services\Weather\Factory\WeatherServiceFactory;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(WeatherService::class,function (){
            return WeatherServiceFactory::make();
        });
    }
}
