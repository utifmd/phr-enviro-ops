<?php

namespace App\Livewire\Operators;

use App\Livewire\Forms\OperatorForm;
use App\Models\Department;
use App\Models\Operator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public OperatorForm $form;
    public ?Collection $departments;

    public function mount(Operator $operator): void
    {
        $this->form->setOperatorModel($operator);
    }

    public function booted(): void
    {
        $this->departments = $this->mappedDepartment();
    }

    private function mappedDepartment(): Collection
    {
        return Department::all()->map(function ($department) {
            $department->value = $department->id;
            return $department;
        });
    }

    /*public function onDepartmentChange(): void
    {
        $this->form->department_id =
    }*/

    /**
     * @throws ValidationException
     */
    public function save(): void
    {
        $this->form->store();

        $this->redirectRoute('operators.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.operator.create');
    }
}
