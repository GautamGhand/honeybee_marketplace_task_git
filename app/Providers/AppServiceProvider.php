<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if (request()->hasHeader('X-Forwarded-Proto') && request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        } else {
            URL::forceScheme('https'); // Force HTTPS strictly
        }
    }
}
