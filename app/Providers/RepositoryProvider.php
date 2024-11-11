<?php

namespace App\Providers;

use App\Repositories\Contracts\ICrewRepository;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\IOperatorRepository;
use App\Repositories\Contracts\IUserCurrentPostRepository;
use App\Repositories\Contracts\IVehicleRepository;
use App\Repositories\CrewRepository;
use App\Repositories\DBRepository;
use App\Repositories\OperatorRepository;
use App\Repositories\UserCurrentPostRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    public array $singletons = [
        IDBRepository::class => DBRepository::class,
        IUserCurrentPostRepository::class => UserCurrentPostRepository::class,
        IOperatorRepository::class => OperatorRepository::class,
        IVehicleRepository::class => VehicleRepository::class,
        ICrewRepository::class => CrewRepository::class,
    ];

    public function provides(): array
    {
        return [
            IDBRepository::class,
            IUserCurrentPostRepository::class,
            IOperatorRepository::class,
            IVehicleRepository::class,
            ICrewRepository::class,
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
