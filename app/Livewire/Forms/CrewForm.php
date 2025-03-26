<?php

namespace App\Livewire\Forms;

use App\Models\ManPower;
use Livewire\Form;

class CrewForm extends Form
{
    public ?ManPower $crewModel;

    public $name = '';
    public $role = '';
    public $company_id = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'role' => 'required',
			'company_id' => 'required|uuid',
        ];
    }

    public function setCrewModel(ManPower $crewModel): void
    {
        $this->crewModel = $crewModel;

        $this->name = $this->crewModel->name;
        $this->role = $this->crewModel->role;
        $this->company_id = $this->crewModel->company_id;
    }

    public function store(): void
    {
        $this->crewModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->crewModel->update($this->validate());

        $this->reset();
    }
}
