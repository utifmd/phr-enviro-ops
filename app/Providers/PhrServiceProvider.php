<?php

namespace App\Providers;

use App\Service\Contracts\IWellService;
use App\Service\WellService;
use Illuminate\Support\ServiceProvider;

class PhrServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public array $singletons = [
        IWellService::class => WellService::class
    ];

    public function provides(): array
    {
        return [
            IWellService::class
        ];
    }
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
