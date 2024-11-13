<?php

namespace App\Livewire\Forms;

use App\Models\Operator;
use Livewire\Form;

class OperatorForm extends Form
{
    public ?Operator $operatorModel;

    public $prefix = '';
    public $postfix = '';
    public $name = '';
    public $short_name = '';
    public $department_id = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'short_name' => 'required|string',
        ];
    }

    public function setOperatorModel(Operator $operatorModel): void
    {
        $this->operatorModel = $operatorModel;

        $this->prefix = $this->operatorModel->prefix;
        $this->postfix = $this->operatorModel->postfix;
        $this->name = $this->operatorModel->name;
        $this->short_name = $this->operatorModel->short_name;
        $this->department_id = $this->operatorModel->department_id;
    }

    public function store(): void
    {
        $this->operatorModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->operatorModel->update($this->validate());

        $this->reset();
    }
}
