<?php

namespace App\Livewire\WorkTripInfos;

use App\Livewire\Forms\WorkTripInfoForm;
use App\Models\WorkTripInfo;
use App\Repositories\Contracts\ILogRepository;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    protected ILogRepository $logRepos;
    public WorkTripInfoForm $form;

    public function boot(ILogRepository $logRepos): void
    {
        $this->logRepos = $logRepos;
    }

    public function mount(WorkTripInfo $workTripInfo): void
    {
        $this->form->setWorkTripInfoModel($workTripInfo);
    }

    private function assignLog(): void
    {
        $highlight = 'updated info ' . $this->form->act_name . ' ' . $this->form->act_process . ' ' . $this->form->area_name;
        $this->logRepos->addLogs('work-trip-infos', $highlight);
    }

    public function save(): void
    {
        $this->form->update();
        $this->assignLog();

        $this->redirectRoute('work-trip-infos.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip-info.edit');
    }
}
