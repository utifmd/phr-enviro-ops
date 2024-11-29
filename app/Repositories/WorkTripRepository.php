<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Models\Area;
use App\Models\WorkTrip;
use App\Models\WorkTripInfo;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActNameEnum;
use App\Utils\ActUnitEnum;
use App\Utils\AreaNameEnum;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
    public function getLocations(string $areaName): array
    {
        return Area::query()
            ->where('name', '=', $areaName)->get()
            ->map(function(Area $area) {
                $area->actName = str_contains($area->location, 'CMTF')
                    ? ActNameEnum::Incoming->value
                    : ActNameEnum::Outgoing->value;
                return $area;
            })
            ->toArray();
    }

    public function addInfo(array $workTripInfo): void
    {
        WorkTripInfo::query()->create($workTripInfo);
    }

    public function updateInfo(array $workTripInfo): void
    {
        WorkTripInfo::query()
            ->find($workTripInfo['id'])
            ->update($workTripInfo);
    }

    public function removeInfoById(string $id): void
    {
        WorkTripInfo::query()->find($id)->delete();
    }

    public function getInfoByDate(string $date): array
    {
        return WorkTripInfo::query()
            ->where('date', $date)->get()->toArray();
    }

    public function getInfoByArea(string $area): LengthAwarePaginator
    {
        return WorkTripInfo::query()
        ->selectRaw('date, act_unit, users.name AS user, SUM(act_value) AS act_value_sum')
        /*->where('user_id', '=', $this->authId, 'and')*/
        ->leftJoin('users', 'users.id', '=', 'work_trip_infos.user_id')
        ->where('work_trip_infos.area_name', '=', $area, 'and')
        ->where('act_unit', '=', ActUnitEnum::LOAD->value)
        ->groupBy('date', 'act_unit', 'user')
        ->paginate();
    }
    public function getInfos(): LengthAwarePaginator
    {
        return WorkTripInfo::query()->paginate();
    }
    public function areInfosExistBy(string $date): bool
    {
        return WorkTripInfo::query()->where('date', '=', $date)->exists();
    }
}
