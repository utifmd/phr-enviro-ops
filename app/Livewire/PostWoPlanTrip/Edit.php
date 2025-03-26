<?php

namespace App\Livewire\PostWoPlanTrip;

use App\Livewire\Forms\PlanTripForm;
use App\Models\PostWoPlanTrip;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public PlanTripForm $form;

    public function mount(PostWoPlanTrip $tripPlan): void
    {
        $this->form->setPlanTripModel($tripPlan);
    }

    public function save(): void
    {
        $this->form->update();

        $this->redirectRoute(PostWoPlanTrip::ROUTE_NAME.'.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.'.PostWoPlanTrip::ROUTE_NAME.'.edit');
    }
}
