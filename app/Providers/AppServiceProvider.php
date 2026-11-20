<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
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
        // Set default locale Carbon to Indonesian
        \Carbon\Carbon::setLocale('id');

        // Strictly prohibit destructive database commands in production (excluding test runs)
        if ($this->app->isProduction() && ! $this->app->runningUnitTests()) {
            DB::prohibitDestructiveCommands(true);
        }
    }
}
