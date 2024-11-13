<?php

namespace App\Livewire\PlanTrips;

use App\Livewire\Forms\PlanTripForm;
use App\Models\PlanTrip;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public PlanTripForm $form;

    public function mount(PlanTrip $tripPlan): void
    {
        $this->form->setPlanTripModel($tripPlan);
    }

    public function save(): void
    {
        $this->form->update();

        $this->redirectRoute(PlanTrip::ROUTE_NAME.'.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.'.PlanTrip::ROUTE_NAME.'.edit');
    }
}
