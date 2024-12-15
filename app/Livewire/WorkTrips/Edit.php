<?php

namespace App\Livewire\WorkTrips;

use App\Livewire\Forms\WorkTripForm;
use App\Models\WorkTrip;
use App\Repositories\Contracts\ILogRepository;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    protected ILogRepository $logRepos;
    public WorkTripForm $form;

    public function boot(ILogRepository $logRepos): void
    {
        $this->logRepos = $logRepos;
    }

    public function mount(WorkTrip $workTrip): void
    {
        $this->form->setWorkTripModel($workTrip);
    }

    private function assignLog(): void
    {
        $highlight = 'updated info ' . $this->form->act_name . ' ' . $this->form->act_process . ' ' . $this->form->area_loc;
        $this->logRepos->addLogs('work-trip-infos', $highlight);
    }

    public function save(): void
    {
        $this->form->update();
        $this->assignLog();

        $this->redirectRoute('work-trips.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip.edit');
    }
}
