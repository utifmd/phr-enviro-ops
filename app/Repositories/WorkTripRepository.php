<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Models\Area;
use App\Models\WorkTrip;
use App\Repositories\Contracts\IWorkTripRepository;
use Illuminate\Support\Collection;

class WorkTripRepository implements IWorkTripRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index(): Collection
    {
        return WorkTrip::all();
    }

    public function getById($id): Collection
    {
        return WorkTrip::query()->find($id);
    }

    public function store(array $data): Collection
    {
        return WorkTrip::query()->create($data);
    }

    public function update(array $data, $id): bool
    {
        return WorkTrip::query()->find($id)->update($data);
    }

    public function delete($id): ?bool
    {
        return WorkTrip::query()->find($id)->delete();
    }

    public function getByPostId($id): Collection
    {
        return WorkTrip::query()->where('post_id', $id)->get();
    }

    function getProcessOptions(?string $actName): array
    {
        if (is_null($actName)) return [];
        return Activity::query()
            ->where('name', '=', $actName)->get()
            ->map(function(Activity $act) {
                $act->name = $act->process;
                $act->value = $act->process;
                return $act;
            })
            ->toArray();
    }

    function getLocationsOptions(?string $areaName): array
    {
        if (is_null($areaName)) return [];
        return Area::query()
            ->where('name', '=', $areaName)->get()
            ->map(function(Area $area) {
                $area->name = $area->location;
                $area->value = $area->location;
                return $area;
            })
            ->toArray();
    }
}
