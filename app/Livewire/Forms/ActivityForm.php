<?php

namespace App\Livewire\Forms;

use App\Models\Activity;
use Livewire\Form;

class ActivityForm extends Form
{
    public ?Activity $activityModel;
    
    public $name = '';
    public $process = '';
    public $unit = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'process' => 'required|string',
			'unit' => 'string',
        ];
    }

    public function setActivityModel(Activity $activityModel): void
    {
        $this->activityModel = $activityModel;
        
        $this->name = $this->activityModel->name;
        $this->process = $this->activityModel->process;
        $this->unit = $this->activityModel->unit;
    }

    public function store(): void
    {
        $this->activityModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->activityModel->update($this->validate());

        $this->reset();
    }
}
