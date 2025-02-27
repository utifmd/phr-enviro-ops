<?php

namespace App\Livewire\WorkTrips\Report;

use App\Models\Post;
use App\Models\WorkTrip;
use App\Models\WorkTripDetail;
use App\Repositories\Contracts\ILogRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActNameEnum;
use App\Utils\Constants;
use App\Utils\Contracts\IUtility;
use App\Utils\PostStatusEnum;
use App\Utils\PostTypeEnum;
use App\Utils\WorkTripDetailTypeEnum;
use App\Utils\WorkTripStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

/*
 * TODO:
 * 1. append recap to view table
 * 2. make sure only approved detail can be read
 * 3. export to excel
 * */
class Index extends Component
{
    protected IUserRepository $usrRepos;
    protected ILogRepository $logRepos;
    protected IUtility $utility;
    protected IWorkTripRepository $wtRepos;

    public array $authUsr, $pivotWorkTrips;
    public string $date, $facility;
    public function boot(
        IUserRepository $usrRepos, ILogRepository $logRepos, IUtility $utility, IWorkTripRepository $wtRepos): void
    {
        $this->usrRepos = $usrRepos;
        $this->utility = $utility;
        $this->logRepos = $logRepos;
        $this->wtRepos = $wtRepos;
    }

    public function mount(): void
    {
        $this->date = date('Y-m-d');

        $this->initAuthUser();
        $this->initAreas();
        $this->initPivotWorkTrips();
    }

    private function initAuthUser(): void
    {
        $this->authUsr = $this->usrRepos->authenticatedUser()->toArray();
    }

    private function initAreas(): void
    {
        $this->facility = $this->wtRepos->getCMTFLocationBy(
            $this->authUsr['area_name']
        );
    }

    private function buildGetPostOfDetailsAreaBy(string $date): Builder
    {
        $builder = Post::query();
        $startEndDate = array(
            Carbon::parse($date)->startOfMonth(),
            Carbon::parse($date)->endOfMonth(),
        );
        $builder
            ->where('type', PostTypeEnum::POST_WELL_TYPE->value)
            ->where('status', PostStatusEnum::CLOSE->value)
            ->whereHas('details', function ($query) use ($startEndDate) { return $query
                ->where('area_name', $this->authUsr['area_name'])
                ->whereBetween('created_at', $startEndDate);
            });
        return $builder;
    }

    private function getPostDetailYHeaderBy(string $date): array
    {
        $builder = $this->buildGetPostOfDetailsAreaBy($date);

        /*$builder->whereHas('workTrips', function ($query) {
            $query->where('status', WorkTripStatusEnum::APPROVED->value);
        });*/
        $mapper = fn ($post) => $post->details->map(function ($detail) {
            $detail->type = $detail['detailIn']['type'];
            $detail->well_name = $detail['detailIn']['well_name'];
            $detail->wbs_number = $detail['detailIn']['wbs_number'];
            $type = $detail->type != WorkTripDetailTypeEnum::DRILLING->value ? ' (Non Rig)' : Constants::EMPTY_STRING;

            $detail->uniqueWellName = $detail->well_name . $type;
            return $detail;
        });
        return $builder->get()->map($mapper)->flatten(1)->unique('uniqueWellName')->toArray();
    }

    private function buildGetDetailBy(string $date, string $wellName, string $detailInType): Builder
    {
        return WorkTripDetail::query()
            ->where('type', ActNameEnum::Incoming->value)
            ->whereHas('detailIn', fn ($query) => $query
                ->where('well_name', $wellName)
                ->where('type', $detailInType)
            )
            ->whereBetween('created_at', [
                Carbon::parse($date)->startOfDay(),
                Carbon::parse($date)->endOfDay(),
            ]);
    }

    private function sumDetailLoadBy(string $date, string $wellName, string $detailInType): int
    {
        return $this->buildGetDetailBy($date, $wellName, $detailInType)->sum('load');
    }

    public function buildGetTripsBy(string $date): Builder
    {
        return WorkTrip::query()->where('date', $date);
    }

    /*public function getSumPlanAndActualBy(
        string $actName, string $actProcess, string $actLoc): array
    {
        return ;
    }*/

    public function sumWorkTripBy(string $date, string $areaName): array
    {
        return $this->buildGetTripsBy($date)
            ->selectRaw('time, act_name, act_process, act_unit, area_loc, type, SUM(act_value) AS total')
            ->where('area_name', $areaName)
            ->where('status', WorkTripStatusEnum::APPROVED->value)
            ->whereHas('post', fn ($query) => $query->where('status', PostStatusEnum::CLOSE->value))
            ->groupBy('time', 'act_name', 'act_process', 'act_unit', 'area_loc', 'type')
            ->get()
            ->toArray();
    }

    public function initPivotWorkTrips(): void
    {
        $pivot = array();
        $sumWorkTripBy = $this->sumWorkTripBy($this->date, $this->authUsr['area_name']);
        $yHeader = $this->utility->getListOfTimes(0, 22);

        foreach ($yHeader as $i => $time) {
            $workTrips = array_filter($sumWorkTripBy, fn($wt) => $wt['time'] == $time);

            if (empty($workTrips)) continue;
            $headerMapper = fn ($wt) =>
                $wt['type'] .' '.
                $wt['act_name'] .' '.
                $wt['act_process'] .(!str_contains($wt['area_loc'], 'CMTF')
                    ? (' to '. $wt['area_loc']) : '') .' ('.
                $wt['act_unit'] .')';

            $pivot['xHeader'] = array_map($headerMapper, $workTrips);
            $pivot['xContent'][$time] = array_map(fn ($wt) => $wt['total'], array_values($workTrips));
        }
        $this->pivotWorkTrips = $pivot;
    }

    public function onDateChange(): void
    {
        $this->initPivotWorkTrips();
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip.report.index');
    }
}
