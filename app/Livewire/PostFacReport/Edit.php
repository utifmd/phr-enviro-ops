<?php

namespace App\Livewire\PostFacReport;

use App\Livewire\Forms\WorkTripForm;
use App\Models\PostFacReport;
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

    public function mount(PostFacReport $workTrip): void
    {
        $this->form->setWorkTripModel($workTrip);
    }

    private function assignLog(): void
    {
        $highlight = 'updated info ' . $this->form->act_name . ' ' . $this->form->act_process . ' ' . $this->form->area_loc;
        $this->logRepos->addLogs('post-fac-threshold', $highlight);
    }

    public function save(): void
    {
        $this->form->update();
        $this->assignLog();

        $this->redirectRoute('post-fac-report.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.post-fac-report.edit');
    }
}
