<?php

namespace App\Livewire\WorkTrips;

use App\Livewire\Forms\WorkTripForm;
use App\Models\WorkTrip;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActNameEnum;
use App\Utils\Contracts\IUtility;
use App\Utils\WorkTripScheduleEnum;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    protected IWorkTripRepository $workTripRepos;
    protected IUtility $util;

    public WorkTripForm $form;
    public array $workTripsState;
    public array $timesState;

    public array $processes;
    public array $locations;
    public array $periods;

    public string $schedule;

    public function mount(WorkTrip $workTrip): void
    {
        $workTrip->post_id = 'none';
        $this->form->setWorkTripModel($workTrip);
    }

    public function booted(
        IWorkTripRepository $workTripRepos, IUtility $util): void
    {
        $this->workTripRepos = $workTripRepos;
        $this->util = $util;

        $this->onActivityInit();
        $this->onScheduleInit();
    }

    private function onActivityInit(): void
    {
        $this->processes = $this->workTripRepos->getProcessOptions(
            $this->form->act_name
        );
        $this->locations = $this->workTripRepos->getLocationsOptions(
            $this->form->area_name
        );
    }

    public function onActivityChange(): void
    {
        $this->onActivityInit();
        $this->adjustActivityUnit();
    }

    public function onStateActivityPressed(): void
    {
        $this->form->validate();
        $workTrip = $this->form->toArray();

        $this->onStateTimeSelection();
        foreach ($this->workTripsState as $i => $trip) {
            if ($workTrip['act_process'] != $trip['act_process']) continue;

            $this->workTripsState[$i]['act_value'] = $this->form->act_value;
            $this->formReset();
            return;
        }
        $this->workTripsState[] = $workTrip;
        $this->formReset();
    }

    private function onStateTimeSelection(): void
    {
        $current = $this->form->time;
        if (in_array($current, $this->timesState)) return;

        $this->timesState[] = $current;
        sort($this->timesState);
    }

    public function formReset(): void
    {
        $this->form->reset('act_value', 'act_name', 'act_process', 'area_loc');
    }

    public function onTableHeaderColPressed(int $i): void
    {
        unset($this->workTripsState[$i]);
    }

    private function adjustActivityUnit(): void
    {
        $unit = $this->form->act_name != ActNameEnum::Production->value
            ? 'load' : 'm3';
        $this->form->act_unit = $unit;
    }

    private function onScheduleInit(): void
    {
        $current = Carbon::now();
        $this->periods = $this->util->getListOfTimesOptions(8, 20);

        $period = collect($this->periods)
            ->map(fn($p) => $p['value'])->toArray();

        $start = Carbon::parse(min($period));
        $end = Carbon::parse(max($period));

        $this->schedule = $current->between($start, $end)
            ? WorkTripScheduleEnum::IN->value
            : WorkTripScheduleEnum::OUT->value;
    }

    public function save(): void
    {
        $this->form->store();

        $this->redirectRoute('work-trips.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip.create');
    }
}
