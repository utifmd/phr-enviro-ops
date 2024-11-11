<?php

namespace App\Livewire\Forms;

use App\Models\Information;
use App\Models\Order;
use App\Models\User;
use App\Models\UserCurrentPost;
use App\Utils\InformationAreaEnum;
use App\Utils\InformationShiftEnum;
use App\Utils\InformationVehicleTypeEnum;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Session;
use Livewire\Form;

class InformationForm extends Form
{
    public ?Information $informationModel;

    public $operator = '';
    public $vehicle_type = '';
    public $police_number = '';
    public $driver_name = '';
    public $start_plan = '';
    public $end_plan = '';
    public $shift = '';
    public $area = '';
    public $post_id = '';

    public function rules(): array
    {
        return [
			'operator' => 'string',
			'vehicle_type' => 'required|string',
			'police_number' => 'string',
			'driver_name' => 'string',
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

        $this->operator = $this->informationModel->operator;
        $this->vehicle_type = InformationVehicleTypeEnum::LV_TYPE->value; // $this->informationModel->vehicle_type;
        $this->police_number = $this->informationModel->police_number;
        $this->driver_name = $this->informationModel->driver_name;
        $this->start_plan = $this->informationModel->start_plan;
        $this->end_plan = $this->informationModel->end_plan;
        $this->shift = InformationShiftEnum::NIGHT->value;
        $this->area = InformationAreaEnum::AREA_CENTRAL->value;
        $this->post_id = $this->informationModel->post_id;
    }

    public function store(): Information
    {
        return $this->informationModel->create(
            $this->validate()
        ); // $this->reset();
    }

    public function setVehicleType(): void
    {
        $this->vehicle_type = InformationVehicleTypeEnum::HE_TYPE->value;
        Log::debug('setVehicleType: '.$this->vehicle_type);
    }

    public function update(): void
    {
        $this->informationModel->update($this->validate());

        $this->reset();
    }
}
