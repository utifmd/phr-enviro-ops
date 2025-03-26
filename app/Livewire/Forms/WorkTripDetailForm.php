<?php

namespace App\Livewire\Forms;

use App\Models\PostFac;
use App\Utils\PostFacReportStatusEnum;
use Livewire\Form;

class WorkTripDetailForm extends Form
{
    public ?PostFac $workTripDetailModel;

    public $transporter = '';
    public $driver = '';
    public $police_number = '';
    public $time_in = '';
    public $type = '';
    public $load = '';
    public $volume = '';
    public $tds = '';
    public $area_name = '';
    public $time_out = '';
    public $status = '';
    public $remarks = '';
    public $post_id = '';
    public $user_id = '';

    public function rules(): array
    {
        return [
			'transporter' => 'required|string',
			'driver' => 'required|string',
			'police_number' => 'required|string',
			'time_in' => 'required',
			'type' => 'required',
			'load' => 'required',
			'area_name' => 'required',
			'time_out' => 'required',
			'status' => 'string',
			'remarks' => 'string',
			'post_id' => 'required',
			'user_id' => 'required',
        ];
    }

    public function setWorkTripDetailModel(PostFac $workTripDetailModel): void
    {
        $this->workTripDetailModel = $workTripDetailModel;

        $this->transporter = $this->workTripDetailModel->transporter;
        $this->driver = $this->workTripDetailModel->driver;
        $this->police_number = $this->workTripDetailModel->police_number;
        $this->time_in = $this->workTripDetailModel->time_in;
        $this->type = $this->workTripDetailModel->type;
        $this->load = $this->workTripDetailModel->load;
        $this->volume = $this->workTripDetailModel->volume;
        $this->tds = $this->workTripDetailModel->tds;
        $this->area_name = $this->workTripDetailModel->area_name;
        $this->time_out = $this->workTripDetailModel->time_out;
        $this->status = $this->workTripDetailModel->status ?? PostFacReportStatusEnum::PENDING->value;
        $this->remarks = $this->workTripDetailModel->remarks;
        $this->post_id = $this->workTripDetailModel->post_id;
        $this->user_id = $this->workTripDetailModel->user_id;
    }

    public function store(): void
    {
        $this->workTripDetailModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->workTripDetailModel->update($this->validate());

        $this->reset();
    }
}
