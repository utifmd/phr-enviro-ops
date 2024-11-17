<?php

namespace App\Providers;

use App\Services\Contracts\IWellService;
use App\Services\WellService;
use Illuminate\Support\ServiceProvider;

class PhrServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IWellService::class, WellService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
