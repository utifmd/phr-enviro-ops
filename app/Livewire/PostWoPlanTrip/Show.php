<?php

namespace App\Livewire\PostWoPlanTrip;

use App\Livewire\Forms\PlanTripForm;
use App\Models\PostWoPlanTrip;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public PlanTripForm $form;

    public function mount(PostWoPlanTrip $tripPlan): void
    {
        $this->form->setPlanTripModel($tripPlan);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.'.PostWoPlanTrip::ROUTE_NAME.'.show', ['tripPlan' => $this->form->planTripModel]);
    }
}
