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
        $isLocal = in_array(request()->getHost(), ['localhost', '127.0.0.1', '::1']);
        if (!$isLocal && (config('app.env') === 'production' || config('app.env') === 'railway' || config('app.force_https', false))) {
            URL::forceScheme('https');
            if (config('app.url')) {
                URL::forceRootUrl(config('app.url'));
            }
        }
    }
}
