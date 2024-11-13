<?php

namespace App\Livewire\Forms;

use App\Models\Crew;
use Livewire\Form;

class CrewForm extends Form
{
    public ?Crew $crewModel;
    
    public $name = '';
    public $role = '';
    public $operator_id = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'role' => 'required',
			'operator_id' => 'required',
        ];
    }

    public function setCrewModel(Crew $crewModel): void
    {
        $this->crewModel = $crewModel;
        
        $this->name = $this->crewModel->name;
        $this->role = $this->crewModel->role;
        $this->operator_id = $this->crewModel->operator_id;
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
