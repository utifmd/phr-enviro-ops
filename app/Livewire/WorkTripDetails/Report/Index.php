<?php

namespace App\Livewire\WorkTripDetails\Report;

use App\Models\Post;
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
        $this->initPivotWorkTripDetails();
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
        return $this->buildGetDetailBy($date, $wellName, $detailInType)
            ->whereHas('post', fn ($query) => $query->where('status', PostStatusEnum::CLOSE->value))
            ->where('status', WorkTripStatusEnum::APPROVED->value)
            ->sum('load');
    }

    public function initPivotWorkTripDetails(): void
    {

        $pivot = array(); $loadGrandTotal = 0;
        $xHeader = $this->utility->datesOfTheMonthOf($this->date);
        $yHeader = $this->getPostDetailYHeaderBy($this->date);

        foreach ($yHeader as $i => $yHead) {
            $pivot[$i]['wbs_number'] = $yHead['wbs_number'];
            $pivot[$i]['wellName'] = $yHead['uniqueWellName'];
            $pivot[$i]['numRow'] = $i +1;

            $loadTotal = 0;
            foreach ($xHeader as $xHead) {
                $detailLoadSum = $this->sumDetailLoadBy($xHead, $yHead['well_name'], $yHead['type']);
                $pivot[$i]['dailyLoadSumOfMonth'][$xHead] = $detailLoadSum; //$pivot[$i]['dailyLoadSumOfMonth'][date('d', strtotime($xHead))] = $detailLoadSum;
                $loadTotal += $detailLoadSum;
            }
            $pivot[$i]['total'] = $loadTotal;
            $loadGrandTotal += $loadTotal;
        }
        $this->pivotWorkTrips['pivot'] = $pivot;
        $this->pivotWorkTrips['grandTotal'] = $loadGrandTotal;
        $this->pivotWorkTrips['xHeaderOfDayCount'] = count($xHeader);
    }

    public function onDateChange(): void
    {
        $this->initPivotWorkTripDetails();
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip-detail.report.index');
    }
}
