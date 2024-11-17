<?php

namespace App\Repositories;

use App\Models\Crew;
use App\Repositories\Contracts\ICrewRepository;
use Illuminate\Support\Collection;

class CrewRepository implements ICrewRepository
{
    function getCrews(?string $operatorId = null): Collection
    {
        $builder = Crew::query();

        if ($operatorId) {
            $builder->where('operator_id', '=', $operatorId);
        }
        return $builder->get();
    }

    function getCrewsOptions(?string $operatorId): array
    {
        return $this->getCrews($operatorId)->transform(function (Crew $crew) {
            $crew->value = $crew->id;
            return $crew;
        })->toArray();
    }
}
