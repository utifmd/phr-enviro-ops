<?php

namespace App\Livewire\WorkTripInDetails;

use App\Livewire\Forms\WorkTripInDetailForm;
use App\Models\WorkTripInDetail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public WorkTripInDetailForm $form;

    public function mount(WorkTripInDetail $workTripDetail)
    {
        $this->form->setWorkTripDetailModel($workTripDetail);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.work-trip-in-detail.show', ['workTripDetail' => $this->form->workTripDetailModel]);
    }
}
