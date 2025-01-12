<?php

namespace App\Repositories;

use App\Mapper\Contracts\IWorkTripMapper;
use App\Models\Crew;
use App\Repositories\Contracts\ICrewRepository;
use Illuminate\Support\Collection;

class CrewRepository implements ICrewRepository
{
    private IWorkTripMapper $wtMapper;

    public function __construct(IWorkTripMapper $wtMapper)
    {
        $this->wtMapper = $wtMapper;
    }

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
        $collection = $this->getCrews($operatorId);
        return $this->wtMapper->mapToOptions($collection)
            ->toArray();
    }
}
