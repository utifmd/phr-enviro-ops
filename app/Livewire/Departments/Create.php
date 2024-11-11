<?php

namespace App\Livewire\Departments;

use App\Livewire\Forms\DepartmentForm;
use App\Models\Department;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public DepartmentForm $form;

    public function mount(Department $department)
    {
        $this->form->setDepartmentModel($department);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('departments.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.department.create');
    }
}
