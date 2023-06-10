<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(125);
        Carbon::macro('dateTimeFormat', function ($type) {
            if ($type == 'date')
                return $this->format('Y-m-d');
            else
                return $this->format('h:i A');
        });
    }
}
