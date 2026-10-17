<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
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
        // Agar nama hari dan bulan tampil dalam Bahasa Indonesia.
        Carbon::setLocale(config('app.locale'));
        Date::setLocale(config('app.locale'));
    }
}
