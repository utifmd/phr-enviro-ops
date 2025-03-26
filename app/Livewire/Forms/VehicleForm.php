<?php

namespace App\Livewire\Forms;

use App\Models\Vehicle;
use Livewire\Form;

class VehicleForm extends Form
{
    public ?Vehicle $vehicleModel;

    public $plat = '';
    public $type = '';
    public $vendor = '';
    public $company_id = '';

    public function rules(): array
    {
        return [
			'plat' => 'required|string',
			'type' => 'required|string',
			'vendor' => 'required|string',
			'company_id' => 'required',
        ];
    }

    public function setVehicleModel(Vehicle $vehicleModel): void
    {
        $this->vehicleModel = $vehicleModel;

        $this->plat = $this->vehicleModel->plat;
        $this->type = $this->vehicleModel->type;
        $this->vendor = $this->vehicleModel->vendor;
        $this->company_id = $this->vehicleModel->company_id;
    }

    public function store(): void
    {
        $this->vehicleModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->vehicleModel->update($this->validate());

        $this->reset();
    }
}
