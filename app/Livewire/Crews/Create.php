<?php

namespace App\Livewire\Crews;

use App\Livewire\Forms\CrewForm;
use App\Models\Crew;
use App\Repositories\Contracts\ILogRepository;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    protected ILogRepository $logRepos;
    public CrewForm $form;

    public function boot(ILogRepository $logRepos): void
    {
        $this->logRepos = $logRepos;
    }

    private function assignLog(): void
    {
        $this->logRepos->addLogs(
            'crews', 'updated crew '.$this->form->name
        );
    }
    public function mount(Crew $crew): void
    {
        $this->form->setCrewModel($crew);
    }

    public function save(): void
    {
        $this->form->store();
        $this->assignLog();

        $this->redirectRoute('crews.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.crew.create');
    }
}
