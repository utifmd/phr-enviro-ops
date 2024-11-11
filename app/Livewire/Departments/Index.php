<?php

namespace App\Livewire\Departments;

use App\Models\Department;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]
    public function render(): View
    {
        $departments = Department::paginate();

        return view('livewire.department.index', compact('departments'))
            ->with('i', $this->getPage() * $departments->perPage());
    }

    public function delete(Department $department)
    {
        $department->delete();

        return $this->redirectRoute('departments.index', navigate: true);
    }
}
