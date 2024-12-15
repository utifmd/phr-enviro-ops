<?php

namespace App\Livewire\Departments;

use App\Livewire\Forms\DepartmentForm;
use App\Models\Department;
use App\Repositories\Contracts\ILogRepository;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public DepartmentForm $form;
    protected ILogRepository $logRepos;

    public function boot(ILogRepository $logRepos): void
    {
        $this->logRepos = $logRepos;
    }

    public function mount(Department $department): void
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
        $this->form->store();
        $this->assignLog();

        $this->redirectRoute('departments.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.department.create');
    }
}
