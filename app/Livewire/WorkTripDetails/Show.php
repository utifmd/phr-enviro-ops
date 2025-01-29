<?php

namespace App\Livewire\WorkTripDetails;

use App\Livewire\Forms\WorkTripDetailForm;
use App\Models\WorkTripDetail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public WorkTripDetailForm $form;

    public function mount(WorkTripDetail $workTripDetail)
    {
        $this->form->setWorkTripDetailModel($workTripDetail);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.work-trip-detail.show', ['workTripDetail' => $this->form->workTripDetailModel]);
    }
}
