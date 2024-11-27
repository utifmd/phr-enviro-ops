<?php

namespace App\Livewire\WorkTripInfos;

use App\Livewire\Forms\WorkTripInfoForm;
use App\Models\WorkTripInfo;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public WorkTripInfoForm $form;

    public function mount(WorkTripInfo $workTripInfo)
    {
        $this->form->setWorkTripInfoModel($workTripInfo);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('work-trip-infos.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.work-trip-info.edit');
    }
}
