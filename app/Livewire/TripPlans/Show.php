<?php

namespace App\Livewire\TripPlans;

use App\Livewire\Forms\TripPlanForm;
use App\Models\TripPlan;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public TripPlanForm $form;

    public function mount(TripPlan $tripPlan)
    {
        $this->form->setTripPlanModel($tripPlan);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.trip-plan.show', ['tripPlan' => $this->form->tripPlanModel]);
    }
}
