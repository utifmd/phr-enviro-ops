<?php

namespace App\Livewire\WorkTrips;

use App\Livewire\Forms\WorkTripForm;
use App\Models\WorkTrip;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public WorkTripForm $form;

    public function mount(WorkTrip $workTrip)
    {
        $this->form->setWorkTripModel($workTrip);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('work-trips.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.work-trip.edit');
    }
}
