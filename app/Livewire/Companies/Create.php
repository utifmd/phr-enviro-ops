<?php

namespace App\Livewire\Companies;

use App\Livewire\Forms\OperatorForm;
use App\Models\Team;
use App\Models\Company;
use App\Repositories\Contracts\ILogRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    protected ILogRepository $logRepos;
    public OperatorForm $form;
    public ?Collection $departments;

    public function mount(Company $operator): void
    {
        $this->form->setOperatorModel($operator);

        $this->departments = $this->mappedDepartment();
    }

    public function boot(ILogRepository $logRepos): void
    {
        $this->logRepos = $logRepos;
    }

    private function mappedDepartment(): Collection
    {
        return Team::all()->map(function ($department) {
            $department->value = $department->id;
            return $department;
        });
    }

    private function assignLog(): void
    {
        $this->logRepos->addLogs(
            'operators', 'added company '.$this->form->name
        );
    }
    /**
     * @throws ValidationException
     */
    public function save(): void
    {
        $this->form->store();
        $this->assignLog();

        $this->redirectRoute('companies.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.company.create');
    }
}
