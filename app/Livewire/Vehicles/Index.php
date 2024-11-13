<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicle;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]
    public function render(): View
    {
        $vehicles = Vehicle::paginate();

        return view('livewire.vehicle.index', compact('vehicles'))
            ->with('i', $this->getPage() * $vehicles->perPage());
    }

    public function delete(Vehicle $vehicle)
    {
        $vehicle->delete();

        return $this->redirectRoute('vehicles.index', navigate: true);
    }
}
