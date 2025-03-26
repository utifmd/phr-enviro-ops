<?php

namespace App\Livewire\PostFacThreshold;

use App\Livewire\Forms\WorkTripInfoForm;
use App\Models\PostFacThreshold;
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

    public function mount(PostFacThreshold $workTripInfo): void
    {
        $this->form->setWorkTripInfoModel($workTripInfo);
    }

    private function assignLog(): void
    {
        $highlight = 'updated info ' . $this->form->act_name . ' ' . $this->form->act_process . ' ' . $this->form->area_name;
        $this->logRepos->addLogs('post-fac-threshold', $highlight);
    }

    public function save(): void
    {
        $this->form->update();
        $this->assignLog();

        $this->redirectRoute('post-fac-threshold.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.post-fac-threshold.edit');
    }
}
