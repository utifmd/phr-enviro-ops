<?php

namespace App\Livewire\Operators;

use App\Livewire\Forms\OperatorForm;
use App\Models\Department;
use App\Models\Operator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
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

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('operators.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.operator.edit');
    }
}
