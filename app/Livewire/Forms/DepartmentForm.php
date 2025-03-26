<?php

namespace App\Livewire\Forms;

use App\Models\Team;
use Livewire\Form;

class DepartmentForm extends Form
{
    public ?Team $departmentModel;

    public $prefix = '';
    public $postfix = '';
    public $name = '';
    public $short_name = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'short_name' => 'required|string',
        ];
    }

    public function setDepartmentModel(Team $departmentModel): void
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
