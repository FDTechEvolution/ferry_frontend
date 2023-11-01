<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

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
        Http::macro('reqres', function() {
            return Http::withHeaders([
                'X-TKSCT' => config('services.api.secret_key')
            ])->baseUrl(config('services.api.base_url'));
        });
    }
}
