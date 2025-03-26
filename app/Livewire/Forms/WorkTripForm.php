<?php

namespace App\Livewire\Forms;

use App\Models\PostFacReport;
use App\Utils\AreaNameEnum;
use App\Utils\PostFacReportTypeEnum;
use Livewire\Form;

class WorkTripForm extends Form
{
    public ?PostFacReport $workTripModel;

    public $type = '';
    public $date = '';
    public $time = '';
    public $act_name = '';
    public $act_process = '';
    public $act_unit = '';
    public $act_value = '';
    public $area_name = '';
    public $area_loc = '';
    public $post_id = '';
    public $user_id = '';

    public function rules(): array
    {
        return [
			'type' => 'required|string',
			'date' => 'required',
			'time' => 'required',
			'act_name' => 'required|string',
			'act_process' => 'required|string',
			'act_unit' => 'required|string',
			'act_value' => 'required|regex:/^[0-9]{1,3}\/[0-9]{1,3}$/',
			'area_name' => 'required|string',
			'area_loc' => 'required|string',
			'post_id' => 'required|string',
			'user_id' => 'required|string',
        ];
    }

    public function setWorkTripModel(PostFacReport $workTripModel): void
    {
        $this->workTripModel = $workTripModel;

        $this->type = PostFacReportTypeEnum::PLAN->value;
        $this->date = date('d-m-Y');
        $this->time = date('H-i-s');
        $this->act_name = $this->workTripModel->act_name;
        $this->act_process = $this->workTripModel->act_process;
        $this->act_unit = $this->workTripModel->act_unit;
        $this->act_value = $this->workTripModel->act_value;
        $this->area_name = AreaNameEnum::MINAS->value;
        $this->area_loc = $this->workTripModel->area_loc;
        $this->post_id = $this->workTripModel->post_id;
    }

    public function store(): void
    {
        $this->workTripModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->workTripModel->update($this->validate());

        $this->reset();
    }
}
