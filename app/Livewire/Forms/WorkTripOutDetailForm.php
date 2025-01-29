<?php

namespace App\Livewire\Forms;

use App\Models\WorkTripDetailOut;
use Livewire\Form;

class WorkTripOutDetailForm extends Form
{
    public ?WorkTripDetailOut $workTripOutDetailModel;

    public $transporter = '';//
    public $driver = ''; //
    public $police_number = ''; //
    public $time_in = '';//
    public $time_out = '';
    public $from_pit = '';
    public $from_facility = ''; //
    public $to_facility = ''; //
    public $type = '';
    public $tds = '';
    public $volume = '';
    public $load = '';
    public $area_name = '';
    public $remarks = '';
    public $post_id = '';
    public $user_id = '';
    public $created_at = '';

    public function rules(): array
    {
        return [
            'transporter' => 'required|string',
            'driver' => 'required|string',
            'police_number' => 'required|string',
            'time_in' => 'required|string',
            'time_out' => 'required|string',
            'from_pit' => 'required|string',
            'from_facility' => 'required|string',
            'to_facility' => 'required|string',
            'type' => 'required|string',
            'tds' => 'integer|nullable',
            'volume' => 'integer|nullable',
            'load' => 'required|integer',
            'area_name' => 'required|string',
            'remarks' => 'required|string',
            'post_id' => 'required|uuid',
            'user_id' => 'required|uuid',
            'created_at' => 'required|string'
        ];
    }

    public function setWorkTripOutDetailModel(WorkTripDetailOut $workTripOutDetailModel): void
    {
        $this->workTripOutDetailModel = $workTripOutDetailModel;

        $this->transporter = $this->workTripOutDetailModel->transporter;
        $this->driver = $this->workTripOutDetailModel->driver;
        $this->police_number = $this->workTripOutDetailModel->police_number;
        $this->time_in = $this->workTripOutDetailModel->time_in;
        $this->time_out = $this->workTripOutDetailModel->time_out;
        $this->from_pit = $this->workTripOutDetailModel->from_pit;
        $this->from_facility = $this->workTripOutDetailModel->from_facility;
        $this->to_facility = $this->workTripOutDetailModel->to_facility;
        $this->type = $this->workTripOutDetailModel->type;
        $this->tds = $this->workTripOutDetailModel->tds;
        $this->volume = $this->workTripOutDetailModel->volume;
        $this->load = $this->workTripOutDetailModel->load;
        $this->area_name = $this->workTripOutDetailModel->area_name;
        $this->remarks = $this->workTripOutDetailModel->remarks;
        $this->post_id = $this->workTripOutDetailModel->post_id;
        $this->user_id = $this->workTripOutDetailModel->user_id;
    }

    public function store(): void
    {
        $this->workTripOutDetailModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->workTripOutDetailModel->update($this->validate());

        $this->reset();
    }
}
