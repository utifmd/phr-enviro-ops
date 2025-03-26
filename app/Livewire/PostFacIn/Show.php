<?php

namespace App\Livewire\PostFacIn;

use App\Livewire\Forms\WorkTripInDetailForm;
use App\Models\PostFacIn;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public WorkTripInDetailForm $form;

    public function mount(PostFacIn $workTripInDetail): void
    {
        $this->form->setWorkTripInDetailModel($workTripInDetail);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.post-fac-in.show', ['workTripDetail' => $this->form->workTripDetailModel]);
    }
}
