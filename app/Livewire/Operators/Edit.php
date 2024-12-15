<?php

namespace App\Livewire\Operators;

use App\Livewire\Forms\OperatorForm;
use App\Models\Department;
use App\Models\Operator;
use App\Repositories\Contracts\ILogRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    protected ILogRepository $logRepos;
    public OperatorForm $form;
    public ?Collection $departments;

    public function mount(Operator $operator): void
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
        return Department::all()->map(function ($department) {
            $department->value = $department->id;
            return $department;
        });
    }

    private function assignLog(): void
    {
        $this->logRepos->addLogs(
            'operators', 'updated company '.$this->form->name
        );
    }
    /**
     * @throws ValidationException
     */
    public function save(): void
    {
        $this->form->update();
        $this->assignLog();

        $this->redirectRoute('operators.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.operator.edit');
    }
}
