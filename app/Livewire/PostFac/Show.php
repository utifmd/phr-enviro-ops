<?php

namespace App\Livewire\PostFac;

use App\Livewire\Forms\WorkTripDetailForm;
use App\Models\PostFac;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public WorkTripDetailForm $form;

    public function mount(PostFac $workTripDetail)
    {
        $this->form->setWorkTripDetailModel($workTripDetail);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post-fac.show', ['workTripDetail' => $this->form->workTripDetailModel]);
    }
}
