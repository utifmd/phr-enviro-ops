<?php

namespace App\Livewire\Forms;

use App\Models\Area;
use Livewire\Form;

class AreaForm extends Form
{
    public ?Area $areaModel;
    
    public $name = '';
    public $location = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'location' => 'required|string',
        ];
    }

    public function setAreaModel(Area $areaModel): void
    {
        $this->areaModel = $areaModel;
        
        $this->name = $this->areaModel->name;
        $this->location = $this->areaModel->location;
    }

    public function store(): void
    {
        $this->areaModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->areaModel->update($this->validate());

        $this->reset();
    }
}
