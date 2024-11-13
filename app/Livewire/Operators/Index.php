<?php

namespace App\Livewire\Operators;

use App\Models\Department;
use App\Models\Operator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public ?string $departmentId;

    protected ?LengthAwarePaginator $operators;
    protected ?Collection $departments;

    public function booted(): void
    {
        $this->departments = $this->mappedDepartment();
        $this->operators = $this->pagedOperator();
    }

    private function mappedDepartment(): Collection
    {
        return Department::all()->map(function ($department) {
            $department->value = $department->id;
            return $department;
        });
    }
    private function pagedOperator(?string $depId = null): LengthAwarePaginator
    {
        $builder = Operator::query();
        if (!is_null($depId)) {
            $builder->where('department_id', '=', $depId);
        }
        return $builder->paginate();
    }
    public function onDepartmentChange(): void
    {
        if ($this->departmentId == "") {
            $this->operators = $this->pagedOperator();
            return;
        }
        $this->operators = $this->pagedOperator($this->departmentId);
    }

    public function delete(Operator $operator): void
    {
        $operator->delete();
        $this->redirectRoute('operators.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $params = [
            'operators' => $this->operators,
            'departments' => $this->departments
        ];
        return view('livewire.operator.index', $params)->with('i',
            $this->getPage() * $params['operators']->perPage()
        );
    }
}
