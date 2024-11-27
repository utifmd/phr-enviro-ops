<?php

namespace App\Livewire\WorkTripInfos;

use App\Livewire\Forms\WorkTripInfoForm;
use App\Models\WorkTripInfo;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public WorkTripInfoForm $form;

    public function mount(WorkTripInfo $workTripInfo)
    {
        $this->form->setWorkTripInfoModel($workTripInfo);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.work-trip-info.show', ['workTripInfo' => $this->form->workTripInfoModel]);
    }
}
