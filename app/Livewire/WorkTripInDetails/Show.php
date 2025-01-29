<?php

namespace App\Livewire\WorkTripInDetails;

use App\Livewire\Forms\WorkTripInDetailForm;
use App\Models\WorkTripDetailIn;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public WorkTripInDetailForm $form;

    public function mount(WorkTripDetailIn $workTripInDetail): void
    {
        $this->form->setWorkTripInDetailModel($workTripInDetail);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip-in-detail.show', ['workTripDetail' => $this->form->workTripDetailModel]);
    }
}
