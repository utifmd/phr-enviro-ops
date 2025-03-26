<?php

namespace App\Livewire\Forms;

use App\Models\PostFacThreshold;
use Livewire\Form;

class WorkTripInfoForm extends Form
{
    public ?PostFacThreshold $workTripInfoModel;

    public $date = '';
    public $time = '';
    public $act_name = '';
    public $act_process = '';
    public $act_unit = '';
    public $act_value = '';
    public $area_name = '';
    public $area_loc = '';
    public $user_id = '';

    public function rules(): array
    {
        return [
			'date' => 'required|string',
			'time' => 'required|string',
			'act_value' => 'required|integer',
        ];
    }

    public function setWorkTripInfoModel(PostFacThreshold $workTripInfoModel): void
    {
        $this->workTripInfoModel = $workTripInfoModel;

        $this->date = $this->workTripInfoModel->date;
        $this->time = $this->workTripInfoModel->time;
        $this->act_name = $this->workTripInfoModel->act_name;
        $this->act_process = $this->workTripInfoModel->act_process;
        $this->act_unit = $this->workTripInfoModel->act_unit;
        $this->act_value = $this->workTripInfoModel->act_value;
        $this->area_name = $this->workTripInfoModel->area_name;
        $this->area_loc = $this->workTripInfoModel->area_loc;
        $this->user_id = $this->workTripInfoModel->user_id;
    }

    public function store(): void
    {
        $this->workTripInfoModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->workTripInfoModel->update($this->validate());

        $this->reset();
    }
}
