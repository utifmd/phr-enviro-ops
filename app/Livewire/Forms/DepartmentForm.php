<?php

namespace App\Livewire\Forms;

use App\Models\Department;
use Livewire\Form;

class DepartmentForm extends Form
{
    public ?Department $departmentModel;
    
    public $prefix = '';
    public $postfix = '';
    public $name = '';
    public $short_name = '';

    public function rules(): array
    {
        return [
			'prefix' => 'string',
			'postfix' => 'string',
			'name' => 'required|string',
			'short_name' => 'required|string',
        ];
    }

    public function setDepartmentModel(Department $departmentModel): void
    {
        $this->departmentModel = $departmentModel;
        
        $this->prefix = $this->departmentModel->prefix;
        $this->postfix = $this->departmentModel->postfix;
        $this->name = $this->departmentModel->name;
        $this->short_name = $this->departmentModel->short_name;
    }

    public function store(): void
    {
        $this->departmentModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->departmentModel->update($this->validate());

        $this->reset();
    }
}
