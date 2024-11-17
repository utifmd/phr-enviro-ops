<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface IVehicleRepository
{
    function getVehicles(?string $operatorId): Collection;
    function getVehiclesOptions(?string $operatorId): array;
}
