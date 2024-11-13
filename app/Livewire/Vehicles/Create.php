<?php

namespace App\Livewire\Vehicles;

use App\Livewire\Forms\VehicleForm;
use App\Models\Vehicle;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class Create extends Component
{
    public VehicleForm $form;

    #[Url]
    public ?string $operatorId;

    public function mount(Vehicle $vehicle): void
    {
        $vehicle->operator_id = $this->operatorId;
        $this->form->setVehicleModel($vehicle);
    }

    public function save(): void
    {
        $this->form->store();

        $this->redirect('/operators/show/'.$this->operatorId, navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.vehicle.create');
    }
}
