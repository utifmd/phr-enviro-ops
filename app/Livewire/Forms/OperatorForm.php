<?php

namespace App\Livewire\Forms;

use App\Models\Operator;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class OperatorForm extends Form
{
    public ?Operator $operatorModel;

    public ?string $prefix;
    public ?string $postfix;
    public ?string $name;
    public ?string $short_name;
    public ?string $department_id;

    public function rules(): array
    {
        return [
			'prefix' => 'string|nullable',
			'postfix' => 'string|nullable',
			'name' => 'required|string',
			'short_name' => 'required|string',
			'department_id' => 'required|string',
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

    /**
     * @throws ValidationException
     */
    public function store(): void
    {
        $this->operatorModel->create($this->validate());

        $this->reset();
    }

    /**
     * @throws ValidationException
     */
    public function update(): void
    {
        $this->operatorModel->update($this->validate());

        $this->reset();
    }
}
