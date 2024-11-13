<?php

namespace App\Livewire\Vehicles;

use App\Livewire\Forms\VehicleForm;
use App\Models\Vehicle;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public VehicleForm $form;

    public function mount(Vehicle $vehicle)
    {
        $this->form->setVehicleModel($vehicle);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.vehicle.show', ['vehicle' => $this->form->vehicleModel]);
    }
}
