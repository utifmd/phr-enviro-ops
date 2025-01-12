<?php

namespace App\Livewire\WorkTripInDetails;

use App\Livewire\Forms\WorkTripInDetailForm;
use App\Models\WorkTripInDetail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public WorkTripInDetailForm $form;

    public function mount(WorkTripInDetail $workTripDetail)
    {
        $this->form->setWorkTripDetailModel($workTripDetail);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('work-trip-details.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.work-trip-in-detail.edit');
    }
}
