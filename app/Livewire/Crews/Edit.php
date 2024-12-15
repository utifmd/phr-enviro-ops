<?php

namespace App\Livewire\Crews;

use App\Livewire\Forms\CrewForm;
use App\Models\Crew;
use App\Repositories\Contracts\ILogRepository;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public CrewForm $form;
    protected ILogRepository $logRepos;

    public function boot(ILogRepository $logRepos): void
    {
        $this->logRepos = $logRepos;
    }

    public function mount(Crew $crew): void
    {
        $this->form->setCrewModel($crew);
    }

    private function assignLog(): void
    {
        $this->logRepos->addLogs(
            'crews', 'updated crew '.$this->form->name
        );
    }

    public function save(): void
    {
        $this->form->update();
        $this->assignLog();

        $this->redirectRoute('crews.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.crew.edit');
    }
}
