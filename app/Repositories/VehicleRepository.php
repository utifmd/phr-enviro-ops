<?php

namespace App\Repositories;

use App\Models\Vehicle;
use App\Models\VehicleClass;
use App\Repositories\Contracts\IVehicleRepository;
use Illuminate\Support\Collection;

class VehicleRepository implements IVehicleRepository
{
    function getVehicles(?string $operatorId = null): Collection
    {
        $builder = Vehicle::query();

        if ($operatorId) {
            $builder->where('operator_id', '=', $operatorId);
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
        return VehicleClass::all()
            ->map(function(VehicleClass $vehicle) {
                $vehicle->name = $vehicle->type;
                $vehicle->value = $vehicle->name;
                return $vehicle;
            })->toArray();
    }
}
