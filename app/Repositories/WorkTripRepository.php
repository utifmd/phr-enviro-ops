<?php

namespace App\Repositories;

use App\Mapper\Contracts\IWorkTripMapper;
use App\Models\Activity;
use App\Models\Area;
use App\Models\PostFacReport;
use App\Models\PostFac;
use App\Models\PostFacIn;
use App\Models\PostFacThreshold;
use App\Models\PostRemark;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActNameEnum;
use App\Utils\ActUnitEnum;
use App\Utils\AreaNameEnum;
use App\Utils\Constants;
use App\Utils\PostWoStatusEnum;
use App\Utils\PostFacReportStatusEnum;
use App\Utils\PostFacReportTypeEnum;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class WorkTripRepository implements IWorkTripRepository
{
    public IWorkTripMapper $mapper;
    /**
     * Create a new class instance.
     */
    public function __construct(IWorkTripMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function index(): Collection
    {
        return PostFacReport::all();
    }

    public function indexByStatus(string $status): Collection
    {
        return PostFacReport::query()->where('status', $status)->get();
    }

    public function getById($id): Collection
    {
        return PostFacReport::query()->find($id);
    }

    public function store(array $data): Collection
    {
        return PostFacReport::query()->create($data);
    }

    public function update(array $data, $id): bool
    {
        return PostFacReport::query()->find($id)->update($data);
    }

    public function delete($id): ?bool
    {
        $workTrip = PostFacReport::query()->find($id);
        if (!$workTrip) return false;

        return $workTrip->delete();
    }

    public function deleteThresholdBy(string $date): ?bool
    {
        $threshold = PostFacThreshold::query()->whereDate('date', $date);
        if (!$threshold) return false;

        return $threshold->delete();
    }

    public function getByPostId($id): Collection
    {
        return PostFacReport::query()->where('post_id', $id)->get();
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

    function getAreas(): array
    {
        $builder = Activity::query()->orderBy('created_at');

        return $builder->get()->toArray();
    }

    function getCMTFLocationBy(string $areaName): ?string
    {
        return Area::query()->where('name', $areaName)->get()
            ->filter(fn (Area $area) => str_contains($area->location, 'CMTF'))
            ->map(fn (Area $area) => $area->location)
            ->first();
    }

    public function getLocations(string $areaName): array
    {
        $builder = Area::query();

        if ($areaName != AreaNameEnum::AllArea->value) {
            $builder->where('name', '=', $areaName);
        }
        return $builder->get()
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
        return PostFacReport::query()
            ->selectRaw(
                'type, date, act_unit, users.name AS user_actual, SUM(act_value) AS value_actual_sum, status')
            ->leftJoin('users', 'users.id', '=', 'post_fac_report.user_id')
            ->where('post_fac_report.area_name', '=', $area, 'and')
            ->where('act_unit', '=', ActUnitEnum::LOAD->value, 'and')
            ->where('type', '=', PostFacReportTypeEnum::ACTUAL->value)
            ->groupBy('type', 'date', 'act_unit', 'user_actual', 'status')
            ->orderByDesc('date')
            ->paginate();
    }

    public function addTrip(array $workTripTrip): void
    {
        PostFacReport::query()->create($workTripTrip);
    }

    public function updateTrip(array $workTripTrip): void
    {
        PostFacReport::query()->find($workTripTrip['id'])->update($workTripTrip);
    }

    public function removeTripById(string $id): void
    {
        $workTrip = PostFacReport::query()->find($id);
        if (!$workTrip) return;

        $workTrip->delete();
    }

    public function getTripByDate(string $date): array
    {
        return PostFacReport::query()
            ->where('date', $date)->get()->toArray();
    }


    private function workTripsBuilderBy(
        string $area, $dateOrDates, $timeOrTimes = null): Builder
    {
        $builder = PostFacReport::query();

        if ($area != AreaNameEnum::AllArea->value) {
            $builder->where('area_name', '=', $area);
        }
        return $this->buildConditionalBy($builder, $dateOrDates, $timeOrTimes);
    }

    public function getTripByDateAndArea(string $date, string $area): array
    {
        $builder = PostFacReport::query()->where('date', $date);

        if ($area != AreaNameEnum::AllArea->value) {
            $builder->where('area_name', '=', $area);
        }
        return $builder->get()->toArray();
    }

    public function getActualTripByPostId(string $postId): array
    {
        return PostFacReport::with('user')
            ->where('type', '=', PostFacReportTypeEnum::ACTUAL->value, 'and')
            ->where('post_id', '=', $postId, 'and')
            ->orderByDesc('time')
            ->get()->toArray();
    }

    public function getActualTripByTimeAndPostId(string $time, string $postId): array
    {
        return PostFacReport::with('user')
            ->where('type', '=', PostFacReportTypeEnum::ACTUAL->value, 'and')
            ->where('post_id', '=', $postId, 'and')
            ->where('time', $time)
            ->get()->toArray();
    }

    public function getTripByDatetime(string $date, string $time): array
    {
        return PostFacReport::query()
            ->where('date', '=', $date, 'and')
            ->where('time', $time)
            ->get()->toArray();
    }

    public function getTripByDatetimeAndArea(
        string $date, string $time, string $area): array
    {
        $builder = PostFacReport::query()
            ->where('date', '=', $date)
            ->where('time', $time);

        if ($area != AreaNameEnum::AllArea->value) {
            $builder->where('area_name', '=', $area);
        }
        return $builder->get()->toArray();
    }

    public function sumTripByArea(string $area): LengthAwarePaginator
    {
        return PostFacReport::query()
            ->selectRaw('date, act_unit, users.name AS user, SUM(act_value) AS act_value_sum')
            ->leftJoin('users', 'users.id', '=', 'post_fac_report.user_id')
            ->where('post_fac_report.area_name', '=', $area, 'and')
            ->where('act_unit', '=', ActUnitEnum::LOAD->value)
            ->groupBy('date', 'act_unit', 'user')
            ->orderByDesc('date')
            ->paginate();
    }
    public function getTrips(): LengthAwarePaginator
    {
        return PostFacReport::query()->paginate();
    }

    public function areTripsExistByDate(string $date): bool
    {
        return PostFacReport::query()
            ->where('date', $date)->exists();
    }

    public function areTripsExistByDateAndArea(string $date, string $area): bool
    {
        $builder = PostFacReport::query()->where('date', $date);

        if ($area != AreaNameEnum::AllArea->value) {
            $builder->where('area_name', '=', $area);
        }
        return $builder->exists();
    }

    public function areTripsExistByDatetime(string $date, string $time): bool
    {
        return PostFacReport::query()
            ->where('date', '=', $date, 'and')
            ->where('time', $time)
            ->exists();
    }

    public function areTripsExistByDatetimeAndArea(string $date, string $time, string $area): bool
    {
        $builder = PostFacReport::query()
            ->where('date', '=', $date)
            ->where('time', $time);

        if ($area != AreaNameEnum::AllArea->value) {
            $builder->where('area_name', '=', $area);
        }
        return $builder->exists();
    }

    public function areTripsExistByDatetimeOrDatesTimeAndArea(
        $dateOrDates, $timeOrTimes, string $area): bool
    {
        return $this->workTripsBuilderBy($area, $dateOrDates, $timeOrTimes)->exists();
    }

    public function addInfo(array $workTripInfo): void
    {
        PostFacThreshold::query()->create($workTripInfo);
    }

    public function updateInfo(array $workTripInfo): void
    {
        PostFacThreshold::query()
            ->find($workTripInfo['id'])
            ->update($workTripInfo);
    }

    public function removeInfoById(string $id): void
    {
        $info = PostFacThreshold::query()->find($id);
        if(!$info) return;

        $info->delete();
    }

    public function getInfoByDate(string $date): array
    {
        return PostFacThreshold::query()
            ->where('date', $date)->get()->toArray();
    }

    public function getInfoByDateAndArea(string $date, string $area): array
    {
        $builder = PostFacThreshold::query()->where('date', $date);

        if ($area != AreaNameEnum::AllArea->value) {
            $builder->where('area_name', '=', $area);
        }
        return $builder->get()->toArray();
    }


    private function workTripInfosBuilderBy(
        string $area, $dateOrDates, $timeOrTimes = null): Builder
    {
        $builder = PostFacThreshold::query();

        if ($area != AreaNameEnum::AllArea->value) {
            $builder->where('area_name', '=', $area);
        }
        return $this->buildConditionalBy($builder, $dateOrDates, $timeOrTimes);
    }

    public function getInfoByDateOrDatesAndArea($dateOrDates, string $area): array
    {
        return $this->workTripInfosBuilderBy($area, $dateOrDates)->get()->toArray();
    }

    public function getInfoByDatetime(string $date, string $time): array
    {
        return PostFacThreshold::query()
            ->where('date', '=', $date, 'and')
            ->where('time', $time)
            ->get()->toArray();
    }

    public function getInfoByDatetimeAndArea(string $date, string $time, string $area): array
    {
        $builder = PostFacThreshold::query()
            ->where('date', '=', $date)
            ->where('time', $time);

        if ($area != AreaNameEnum::AllArea->value) {
            $builder->where('area_name', '=', $area);
        }
        return $builder->get()->toArray();
    }
    public function getInfoByDatetimeOrDatesTimeAndArea(
        $dateOrDates, $timeOrTimes, string $area): array
    {
        return $this->workTripInfosBuilderBy(
            $area, $dateOrDates, $timeOrTimes)->get()->toArray();
    }

    public function sumInfoByArea(string $area): LengthAwarePaginator
    {
        $builder = PostFacThreshold::query()
            ->selectRaw('date, act_unit, users.name AS user, SUM(act_value) AS act_value_sum') /*->where('user_id', '=', $this->authId, 'and')*/
            ->leftJoin('users', 'users.id', '=', 'post_fac_threshold.user_id')
            ->where('act_unit', '=', ActUnitEnum::LOAD->value);

        if ($area != AreaNameEnum::AllArea->value) {
            $builder->where('post_fac_threshold.area_name', '=', $area);
        }
        return $builder
            ->groupBy('date', 'act_unit', 'user')
            ->orderByDesc('date')
            ->paginate();
    }
    public function getInfos(): LengthAwarePaginator
    {
        return PostFacThreshold::query()->paginate();
    }
    public function areInfosExistByDate(string $date): bool
    {
        return PostFacThreshold::query()
            ->where('date', $date)
            ->exists();
    }

    public function areInfosExistByDateAndArea(string $date, string $area): bool
    {
        $builder = PostFacThreshold::query();

        if ($area != AreaNameEnum::AllArea->value) {
            $builder->where('area_name', '=', $area);
        }
        return $builder->where('date', $date)
            ->exists();
    }

    public function areInfosExistByDateOrDatesAndArea($dateOrDates, string $area): bool
    {
        return $this->workTripInfosBuilderBy($area, $dateOrDates)->exists();
    }

    public function areInfosExistByArea(string $area): bool
    {
        $builder = PostFacThreshold::query();

        if ($area != AreaNameEnum::AllArea->value) {
            $builder->where('area_name', '=', $area);
        }
        return $builder->exists();
    }

    public function areInfosExistByDatetime(string $date, string $time): bool
    {
        return PostFacThreshold::query()
            ->where('date', '=', $date, 'and')
            ->where('time', $time)
            ->exists();
    }

    public function areInfosExistByDatetimeAndArea(string $date, string $time, string $area): bool
    {
        $builder = PostFacThreshold::query()
            ->where('date', '=', $date)
            ->where('time', $time);

        if ($area != AreaNameEnum::AllArea->value) {
            $builder->where('area_name', '=', $area);
        }
        return $builder->exists();
    }

    public function areInfosExistByDatetimeOrDatesTimeAndArea(
        $dateOrDates, $timeOrTimes, string $area): bool
    {
        return $this->workTripInfosBuilderBy(
            $area, $dateOrDates, $timeOrTimes)->exists();
    }

    public function getLatestInfosDateByArea(string $area): ?string
    {
        $builder = PostFacThreshold::query();

        if ($area != AreaNameEnum::AllArea->value) {
            $builder->where('area_name', '=', $area);
        }
        return $builder->orderByDesc('date')->first()->date;
    }

    public function getLatestInfosDateByDateOrDatesAndArea($dateOrDates, string $area): ?string
    {
        return $this->workTripInfosBuilderBy($area, $dateOrDates)
            ->orderByDesc('date')->first()->date;
    }
    public function sumActualByAreaAndDate(mixed $areaName, mixed $date): int
    {
        $builder = PostFacReport::query()
            ->selectRaw('SUM(act_value) AS act_value_sum')
            ->where('type', '=', PostFacReportTypeEnum::ACTUAL->value)
            ->where('act_unit', '=', ActUnitEnum::LOAD->value)
            ->where('date', $date);

        if ($areaName != AreaNameEnum::AllArea->value) {
            $builder->where('area_name', '=', $areaName);
        }
        return $builder->get()->first()->act_value_sum;
    }

    public function addNotesWith(
        string $postId, string $userId, string $message): void
    {
        PostRemark::query()->create([
            'post_id' => $postId, 'user_id' => $userId, 'message' => $message,
        ]);
    }

    public function addNotes(array $data): void
    {
        PostRemark::query()->create($data);
    }

    private function notesByDateAndUserIdBuilder(
        string $userId, string $date): Builder
    {
        return PostRemark::with('user')
            ->where('user_id', '=', $userId, 'and')
            ->whereBetween('created_at', [
                Carbon::parse($date)->startOfDay(),
                Carbon::parse($date)->endOfDay(),
            ]);
    }

    public function areNotesByDateAndUserIdExist(string $userId, string $date): bool
    {
        return $this->notesByDateAndUserIdBuilder($userId, $date)->exists();
    }

    public function updateNotesByDateAndUserId(
        string $userId, string $date, string $message): void
    {
        $this->notesByDateAndUserIdBuilder($userId, $date)
            ->update(['message' => $message, 'created_at' => $date]);
    }

    public function updateNotesByPostId(string $id, string $message): void
    {
        PostRemark::query()->where('post_id', $id)->update(['message' => $message]);
    }

    public function getNotesByDateAndUserId(string $date, string $userId): array
    {
        $builder = PostRemark::with('user')
            ->where('user_id', '=', $userId, 'and')
            ->whereBetween('created_at', [
                Carbon::parse($date)->startOfDay(),
                Carbon::parse($date)->endOfDay(),
            ]);

        return $builder->get()->toArray();
    }

    public function getNotesByArea(string $areaName): Collection
    {
        $builder = PostRemark::query();

        if ($areaName != AreaNameEnum::AllArea->value) {
            $builder->whereHas('user', function ($query) use ($areaName) {
                $query->where('area_name', '=', $areaName);
            });
        }
        return $builder
            ->orderByDesc('created_at')
            ->limit(PostRemark::PER_PAGE)->get();
    }

    public function getNotesByDateArea(
        string $areaName, string $startDate, string $endDate): Collection
    {
        $builder = PostRemark::query();

        if ($areaName != AreaNameEnum::AllArea->value) {
            $builder->whereHas('user', function ($query) use ($areaName) {
                $query->where('area_name', '=', $areaName);
            });
        }
        return $builder
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ])
            ->orderByDesc('created_at')
            ->limit(PostRemark::PER_PAGE)
            ->get();
    }

    public function tripsExistByDateTimeTypeProcLocBuilder(array $trip): Builder
    {
        return PostFacReport::query()
            ->where('date', '=', $trip['date'], 'and')
            ->where('time', '=', $trip['time'], 'and')
            ->where('type', '=', $trip['type'], 'and')
            ->where('act_process', '=', $trip['act_process'], 'and')
            ->where('area_loc', $trip['area_loc']);
    }

    public function infosExistByDateTimeTypeProcLocBuilder(array $info): Builder
    {
        return PostFacThreshold::query()
            ->where('date', '=', $info['date'], 'and')
            ->where('time', '=', $info['time'], 'and')
            ->where('act_process', '=', $info['act_process'], 'and')
            ->where('area_loc', $info['area_loc']);
    }

    public function getDetailByDateTimeFacBuilder(
        string $createdAt, string $time, string $facility): Builder
    {
        return $this->detailByDateTimeFacBuilder($createdAt, $time, $facility);
    }

    public function getInDetailByDateTimeFacBuilder(
        string $createdAt, string $time, string $facility): Builder {

        return $this->detailByDateTimeFacBuilder(
            $createdAt, $time, $facility, ActNameEnum::Incoming->value
        );
    }

    public function detailBuilder(string $createdAt): Builder
    {
        return PostFac::query()->whereBetween('created_at', [
                Carbon::parse($createdAt)->startOfDay(),
                Carbon::parse($createdAt)->endOfDay(),
            ]);
    }

    public function detailByDateTimeFacBuilder(
        string $createdAt, string $time, string $facility, ?string $actName = null): Builder
    {
        $builder = $this->detailBuilder($createdAt)->where('time_in', $time); // ->orWhere('time_in', $time)

        if (is_null($actName)) return $builder;

        if($actName != ActNameEnum::Incoming->value) {
            $builder->whereHas('postFacOut', function ($query) use ($facility) {
                $query->where('from_facility', '=', $facility);
            });
        } else {
            $builder->whereHas('postFacIn', function ($query) use ($facility) {
                $query->where('facility', '=', $facility);
            });
        }

        return $builder;
    }

    public function countPendingWorkTrip(array $workTrips): int
    {
        return collect($workTrips)
            ->filter(fn ($wt) =>
                $wt->status == PostWoStatusEnum::STATUS_PENDING->value)
            ->count();
    }

    private function buildConditionalBy(
        Builder $builder, $dateOrDates, $timeOrTimes): Builder
    {
        if (is_array($dateOrDates)) {
            $builder->whereIn('date', $dateOrDates);
        } else {
            //$builder->whereDate('date', $dateOrDates);

            $builder->whereBetween('date', [
                Carbon::parse($dateOrDates)->startOfDay(),
                Carbon::parse($dateOrDates)->endOfDay(),
            ]);
        }
        if (is_null($timeOrTimes)) return $builder;

        if (is_array($timeOrTimes)) {
            $builder->whereIn('time', $timeOrTimes);
        } else {
            $builder->whereTime('time', $timeOrTimes);
        }
        return $builder;
    }
}
