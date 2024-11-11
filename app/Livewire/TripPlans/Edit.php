<?php

namespace App\Livewire\TripPlans;

use App\Livewire\Forms\TripPlanForm;
use App\Models\TripPlan;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public TripPlanForm $form;

    public function mount(TripPlan $tripPlan)
    {
        $this->form->setTripPlanModel($tripPlan);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('trip-plans.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.trip-plan.edit');
    }
}
