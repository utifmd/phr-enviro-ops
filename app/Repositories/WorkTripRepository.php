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
use App\Utils\WorkTripStatusEnum;
use App\Utils\WorkTripTypeEnum;
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

    public function indexByStatus(string $status): Collection
    {
        return WorkTrip::query()->where('status', $status)->get();
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

    public function sumInfoAndTripByArea(string $area): LengthAwarePaginator
    {
        return WorkTrip::query()
            ->selectRaw(
                'type, date, act_unit, users.name AS user_actual, SUM(act_value) AS value_actual_sum, status')
            ->leftJoin('users', 'users.id', '=', 'work_trips.user_id')
            ->where('work_trips.area_name', '=', $area, 'and')
            ->where('act_unit', '=', ActUnitEnum::LOAD->value, 'and')
            ->where('type', '=', WorkTripTypeEnum::ACTUAL->value)
            ->groupBy('type', 'date', 'act_unit', 'user_actual', 'status')
            ->paginate();
    }

    public function addTrip(array $workTripTrip): void
    {
        WorkTrip::query()->create($workTripTrip);
    }

    public function updateTrip(array $workTripTrip): void
    {
        WorkTrip::query()
            ->find($workTripTrip['id'])
            ->update($workTripTrip);
    }

    public function removeTripById(string $id): void
    {
        WorkTrip::query()->find($id)->delete();
    }

    public function getTripByDate(string $date): array
    {
        return WorkTrip::query()
            ->where('date', $date)->get()->toArray();
    }

    public function getTripByDatetime(string $date, string $time): array
    {
        return WorkTrip::query()
            ->where('date', '=', $date, 'and')
            ->where('time', $time)
            ->get()->toArray();
    }

    public function sumTripByArea(string $area): LengthAwarePaginator
    {
        return WorkTrip::query()
            ->selectRaw('date, act_unit, users.name AS user, SUM(act_value) AS act_value_sum')
            ->leftJoin('users', 'users.id', '=', 'work_trips.user_id')
            ->where('work_trips.area_name', '=', $area, 'and')
            ->where('act_unit', '=', ActUnitEnum::LOAD->value)
            ->groupBy('date', 'act_unit', 'user')
            ->paginate();
    }
    public function getTrips(): LengthAwarePaginator
    {
        return WorkTrip::query()->paginate();
    }

    public function areTripsExistByDate(string $date): bool
    {
        return WorkTrip::query()
            ->where('date', $date)->exists();
    }

    public function areTripsExistByDatetime(string $date, string $time): bool
    {
        return WorkTrip::query()
            ->where('date', '=', $date, 'and')
            ->where('time', $time)
            ->exists();
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

    public function getInfoByDatetime(string $date, string $time): array
    {
        return WorkTripInfo::query()
            ->where('date', '=', $date, 'and')
            ->where('time', $time)
            ->get()->toArray();
    }

    public function sumInfoByArea(string $area): LengthAwarePaginator
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

    public function mapTripPairActualValue(array $tripState): array
    {
        $actualTrips = [];
        $planTrips = [];
        foreach ($tripState as $trip) {
            if($trip['type'] != WorkTripTypeEnum::PLAN->value) continue;
            $planTrips[] = $trip;
        }
        foreach ($tripState as $i => $trip) {
            if($trip['type'] != WorkTripTypeEnum::ACTUAL->value) continue;
            $trip['act_value'] = $trip['act_value'].'/'.$planTrips[$i]['act_value'];
            $actualTrips[] = $trip;
        }
        return $actualTrips;
    }
    public function mapTripUnpairActualValue(array $tripState): array
    {
        $trips = [];
        foreach ($tripState as $trip) {
            $trip['act_value'] = explode('/', $trip['act_value'])[0];
            $trips[] = $trip;
        }
        return $trips;
    }
    public function sumActualByAreaAndDate(mixed $areaName, mixed $date): int
    {
        $collection = WorkTrip::query()
            ->selectRaw('SUM(act_value) AS act_value_sum')
            ->where('type', '=', WorkTripTypeEnum::ACTUAL->value, 'and')
            ->where('area_name', '=', $areaName, 'and')
            ->where('act_unit', '=', ActUnitEnum::LOAD->value, 'and')
            ->where('date', $date)
            ->get();

        return $collection
            ->first()
            ->act_value_sum;
    }
}
