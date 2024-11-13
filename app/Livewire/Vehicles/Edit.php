<?php

namespace App\Livewire\Vehicles;

use App\Livewire\Forms\VehicleForm;
use App\Models\Vehicle;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public VehicleForm $form;

    public function mount(Vehicle $vehicle)
    {
        $this->form->setVehicleModel($vehicle);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('vehicles.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.vehicle.edit');
    }
}
