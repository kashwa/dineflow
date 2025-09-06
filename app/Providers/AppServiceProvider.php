<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
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
        RateLimiter::for('tenant-api', function ($request) {
        $tenant = $request->attributes->get('tenant');
        $idPart = $tenant ? $tenant->slug : 'no-tenant';
        $userPart = optional($request->user())->id ?? $request->ip();

        // Example: 120 requests/min per (tenant + user/ip)
        return [ Limit::perMinute(120)->by($idPart.'|'.$userPart) ];
    });
    }
}
