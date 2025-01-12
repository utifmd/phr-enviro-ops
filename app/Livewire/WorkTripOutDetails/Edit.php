<?php

namespace App\Livewire\WorkTripOutDetails;

use App\Livewire\Forms\WorkTripOutDetailForm;
use App\Models\WorkTripOutDetail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public WorkTripOutDetailForm $form;

    public function mount(WorkTripOutDetail $workTripOutDetail)
    {
        $this->form->setWorkTripOutDetailModel($workTripOutDetail);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('work-trip-out-details.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.work-trip-out-detail.edit');
    }
}
