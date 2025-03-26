<?php

namespace App\Livewire\PostFacOut;

use App\Livewire\Forms\WorkTripOutDetailForm;
use App\Models\PostFacOut;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public WorkTripOutDetailForm $form;

    public function mount(PostFacOut $workTripOutDetail)
    {
        $this->form->setWorkTripOutDetailModel($workTripOutDetail);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post-fac-out.show', ['workTripOutDetail' => $this->form->workTripOutDetailModel]);
    }
}
