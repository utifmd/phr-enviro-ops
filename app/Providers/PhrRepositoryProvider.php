<?php

namespace App\Providers;

use App\Repositories\Contracts\ICrewRepository;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\ILogRepository;
use App\Repositories\Contracts\IOperatorRepository;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IUserCurrentPostRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IVehicleRepository;
use App\Repositories\Contracts\IWellMasterRepository;
use App\Repositories\Contracts\IWorkOrderRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Repositories\CrewRepository;
use App\Repositories\DBRepository;
use App\Repositories\LogRepository;
use App\Repositories\OperatorRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserCurrentPostRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use App\Repositories\WellMasterRepository;
use App\Repositories\WorkOrderRepository;
use App\Repositories\WorkTripRepository;
use Illuminate\Support\ServiceProvider;

class PhrRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IDBRepository::class, DBRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IPostRepository::class, PostRepository::class);
        $this->app->bind(IWorkTripRepository::class, WorkTripRepository::class);
        $this->app->bind(IWorkOrderRepository::class, WorkOrderRepository::class);
        $this->app->bind(IWellMasterRepository::class, WellMasterRepository::class);
        $this->app->bind(IUserCurrentPostRepository::class, UserCurrentPostRepository::class);
        $this->app->bind(IOperatorRepository::class, OperatorRepository::class);
        $this->app->bind(IVehicleRepository::class, VehicleRepository::class);
        $this->app->bind(ICrewRepository::class, CrewRepository::class);
        $this->app->bind(ILogRepository::class, LogRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
