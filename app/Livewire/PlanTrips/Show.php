<?php

namespace App\Livewire\PlanTrips;

use App\Livewire\Forms\PlanTripForm;
use App\Models\PlanTrip;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public PlanTripForm $form;

    public function mount(PlanTrip $tripPlan): void
    {
        $this->form->setPlanTripModel($tripPlan);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.'.PlanTrip::ROUTE_NAME.'.show', ['tripPlan' => $this->form->planTripModel]);
    }
}
