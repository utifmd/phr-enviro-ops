<?php

namespace App\Repositories;

use App\Models\Vehicle;
use App\Models\Equipment;
use App\Repositories\Contracts\IVehicleRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class VehicleRepository implements IVehicleRepository
{
    function getVehicles(?string $operatorId = null): Collection
    {
        $builder = Vehicle::query();

        if ($operatorId) {
            $builder->where('company_id', '=', $operatorId);
        }
        return $builder->get();
    }

    function getVehiclesOptions(?string $operatorId): array
    {
        return $this->getVehicles($operatorId)->transform(function (Vehicle $vehicle) {
            $vehicle->name = $vehicle->plat;
            $vehicle->value = $vehicle->id;
            return $vehicle;
        })->toArray();
    }
    function getVehicleTypesOptions(): array
    {
        return Equipment::all()
            ->map(function(Equipment $vehicle) {
                $vehicle->name = $vehicle->type;
                $vehicle->value = $vehicle->name;
                return $vehicle;
            })->toArray();
    }

    function vehiclesByQueryBuilder(string $query): Builder
    {
        return Vehicle::query()
            ->whereLike('plat', "%$query%")
            ->orderByDesc('created_at');
    }

    function getVehiclesByOperatorIdQuery(string $operatorId, string $query, ?int $limit): Collection
    {
        return $this->vehiclesByQueryBuilder($query)
            ->where('company_id', $operatorId)
            ->limit($limit)->get();
    }


    function getVehiclesByQuery(string $query, ?int $limit = 5): Collection
    {
        return $this->vehiclesByQueryBuilder($query)->limit($limit)->get();
    }
}
