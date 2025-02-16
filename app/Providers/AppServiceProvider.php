<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        Model::preventLazyLoading();

        RateLimiter::for('jobs', function ($jobs){
            return Limit::perSecond(10); // Limiting execution of 10 jobs per second 
        });

        RateLimiter::for('newsletter', function (Request $request){
            return Limit::perHour(1); // Limiting 1 request per hour
        });
    }
}
