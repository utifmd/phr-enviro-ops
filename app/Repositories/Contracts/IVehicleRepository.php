<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface IVehicleRepository
{
    function getVehicles(?string $operatorId): Collection;
    function getVehiclesOptions(?string $operatorId): array;
    function getVehicleTypesOptions(): array;

    function vehiclesByQueryBuilder(string $query): Builder;
    function getVehiclesByQuery(string $query, ?int $limit): Collection;
    function getVehiclesByOperatorIdQuery(string $operatorId, string $query, ?int $limit): Collection;
}
