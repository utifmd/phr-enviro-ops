<?php

namespace App\Livewire\Teams;

use App\Livewire\Forms\DepartmentForm;
use App\Models\Team;
use App\Repositories\Contracts\ILogRepository;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    protected ILogRepository $logRepos;
    public DepartmentForm $form;

    public function boot(ILogRepository $logRepos): void
    {
        $this->logRepos = $logRepos;
    }

    public function mount(Team $department): void
    {
        $this->form->setDepartmentModel($department);
    }

    private function assignLog(): void
    {
        $this->logRepos->addLogs(
            'departments', 'updated department '.$this->form->name
        );
    }

    public function save(): void
    {
        $this->form->update();

        $this->redirectRoute('teams.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.team.edit');
    }
}
