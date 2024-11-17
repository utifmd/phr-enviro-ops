<?php

namespace App\Livewire\WorkTrips;

use App\Livewire\Forms\WorkTripForm;
use App\Models\WorkTrip;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public WorkTripForm $form;

    public function mount(WorkTrip $workTrip)
    {
        $this->form->setWorkTripModel($workTrip);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.work-trip.show', ['workTrip' => $this->form->workTripModel]);
    }
}
