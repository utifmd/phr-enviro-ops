<?php

namespace App\Livewire\Forms;

use App\Models\Information;
use Livewire\Form;

class InformationForm extends Form
{
    public ?Information $informationModel;

    public $operator_id = '';
    public $vehicle_type = '';
    public $vehicle_id = '';
    public $crew_id = '';
    public $start_plan = '';
    public $end_plan = '';
    public $shift = '';
    public $area = '';
    public $post_id = '';

    public function rules(): array
    {
        return [
			'operator_id' => 'required|string',
			'vehicle_type' => 'required|string',
			'vehicle_id' => 'required|string',
			'crew_id' => 'required|string',
			'start_plan' => 'required|date',
			'end_plan' => 'required|date',
			'shift' => 'required|string',
			'area' => 'required|string',
			'post_id' => 'required|string',
        ];
    }

    public function setInformationModel(Information $informationModel): void
    {
        $this->informationModel = $informationModel;

        $this->operator_id = $this->informationModel->operator_id;
        $this->vehicle_type = $this->informationModel->vehicle_type;
        $this->vehicle_id = $this->informationModel->vehicle_id;
        $this->crew_id = $this->informationModel->crew_id;
        $this->start_plan = $this->informationModel->start_plan;
        $this->end_plan = $this->informationModel->end_plan;
        $this->shift = $this->informationModel->shift;
        $this->area = $this->informationModel->area;
        $this->post_id = $this->informationModel->post_id;
    }

    public function store(): Information
    {
        $validated = $this->validate();

        return $this->informationModel->create($validated);
    }

    public function update(): void
    {
        $this->informationModel->update($this->validate());

        $this->reset();
    }
}
