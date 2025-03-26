<?php

namespace App\Livewire\PostFacThreshold;

use App\Livewire\Forms\WorkTripInfoForm;
use App\Models\PostFacThreshold;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public WorkTripInfoForm $form;

    public function mount(PostFacThreshold $workTripInfo)
    {
        $this->form->setWorkTripInfoModel($workTripInfo);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post-fac-threshold.show', ['workTripInfo' => $this->form->workTripInfoModel]);
    }
}
