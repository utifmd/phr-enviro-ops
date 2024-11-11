<?php

namespace App\Livewire\Departments;

use App\Livewire\Forms\DepartmentForm;
use App\Models\Department;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public DepartmentForm $form;

    public function mount(Department $department)
    {
        $this->form->setDepartmentModel($department);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.department.show', ['department' => $this->form->departmentModel]);
    }
}
