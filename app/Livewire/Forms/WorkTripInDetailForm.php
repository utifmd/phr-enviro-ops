<?php

namespace App\Livewire\Forms;

use App\Models\WorkTripInDetail;
use App\Utils\Constants;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class WorkTripInDetailForm extends Form
{
    public ?WorkTripInDetail $workTripDetailModel;

    public ?string $transporter;
    public ?string $driver;
    public ?string $police_number;
    public ?string $time_in;
    public ?string $well_name;
    public ?string $type;
    public ?string $rig_name;
    public ?int $load;
    public ?int $volume;
    public ?int $tds;
    public ?string $facility;
    public ?string $area_name;
    public ?string $wbs_number;
    public ?string $time_out;
    public ?string $remarks;
    public ?string $post_id;
    public ?string $user_id;
    public ?string $created_at;

    public function rules(): array
    {
        return [
			'transporter' => 'required|string',
			'driver' => 'required|string',
			'police_number' => 'required|string',
			'time_in' => 'required|string',
			'well_name' => 'required|string',
			'type' => 'required|string',
			'rig_name' => 'required|string',
			'volume' => 'integer|nullable',
			'tds' => 'integer|nullable',
			'remarks' => 'string|nullable',
			'load' => 'required|integer',
			'facility' => 'required|string',
			'area_name' => 'required|string',
			'wbs_number' => 'required|string',
			'time_out' => 'required|string',
			'post_id' => 'required|uuid',
			'user_id' => 'required|uuid',
			'created_at' => 'required|string'
        ];
    }

    public function setWorkTripInDetailModel(WorkTripInDetail $workTripDetailModel): void
    {
        $this->workTripDetailModel = $workTripDetailModel;

        $this->transporter = $this->workTripDetailModel->transporter;
        $this->driver = $this->workTripDetailModel->driver;
        $this->police_number = $this->workTripDetailModel->police_number;
        $this->time_in = $this->workTripDetailModel->time_in ?? '00:00:00';
        $this->well_name = $this->workTripDetailModel->well_name;
        $this->type = $this->workTripDetailModel->type;
        $this->rig_name = $this->workTripDetailModel->rig_name;
        $this->load = $this->workTripDetailModel->load ?? 1;
        $this->volume = $this->workTripDetailModel->volume;
        $this->tds = $this->workTripDetailModel->tds;
        $this->facility = $this->workTripDetailModel->facility;
        $this->area_name = $this->workTripDetailModel->area_name;
        $this->wbs_number = $this->workTripDetailModel->wbs_number;
        $this->time_out = $this->workTripDetailModel->time_out;
        $this->remarks = $this->workTripDetailModel->remarks ?? Constants::EMPTY_STRING;
        $this->post_id = $this->workTripDetailModel->post_id;
        $this->user_id = $this->workTripDetailModel->user_id;
        $this->created_at = date('Y-m-d', strtotime($this->workTripDetailModel->created_at));
    }

    /**
     * @throws ValidationException
     */
    public function store(): void
    {
        $this->workTripDetailModel->create($this->validate());

        $this->reset();
    }

    /**
     * @throws ValidationException
     */
    public function update(): void
    {
        $this->workTripDetailModel->update($this->validate());

        $this->reset();
    }
}
