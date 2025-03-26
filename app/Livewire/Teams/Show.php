<?php

namespace App\Livewire\Teams;

use App\Livewire\Forms\DepartmentForm;
use App\Models\Team;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public DepartmentForm $form;

    public function mount(Team $department)
    {
        $this->form->setDepartmentModel($department);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.team.show', ['department' => $this->form->departmentModel]);
    }
}
