<?php

namespace App\Providers;

use App\Repositories\Contracts\ICrewRepository;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\IOperatorRepository;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IUploadedUrlRepository;
use App\Repositories\Contracts\IUserCurrentPostRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IVehicleRepository;
use App\Repositories\Contracts\IWellMasterRepository;
use App\Repositories\Contracts\IWorkOrderRepository;
use App\Repositories\CrewRepository;
use App\Repositories\DBRepository;
use App\Repositories\OperatorRepository;
use App\Repositories\PostRepository;
use App\Repositories\UploadedUrlRepository;
use App\Repositories\UserCurrentPostRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use App\Repositories\WellMasterRepository;
use App\Repositories\WorkOrderRepository;
use Illuminate\Support\ServiceProvider;

class PhrRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    public array $singletons = [
        IDBRepository::class => DBRepository::class,
        IUserRepository::class => UserRepository::class,
        IPostRepository::class => PostRepository::class,
        IUploadedUrlRepository::class => UploadedUrlRepository::class,
        IWorkOrderRepository::class => WorkOrderRepository::class,
        IWellMasterRepository::class => WellMasterRepository::class,
        IUserCurrentPostRepository::class => UserCurrentPostRepository::class,
        IOperatorRepository::class => OperatorRepository::class,
        IVehicleRepository::class => VehicleRepository::class,
        ICrewRepository::class => CrewRepository::class,
    ];

    public function provides(): array
    {
        return [
            IDBRepository::class,
            IUserRepository::class,
            IPostRepository::class,
            IUploadedUrlRepository::class,
            IWorkOrderRepository::class,
            IWellMasterRepository::class,
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
