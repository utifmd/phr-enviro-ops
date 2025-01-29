<?php

namespace App\Livewire\WorkTripDetails;

use App\Livewire\Forms\WorkTripDetailForm;
use App\Models\WorkTripDetail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public WorkTripDetailForm $form;

    public function mount(WorkTripDetail $workTripDetail)
    {
        $this->form->setWorkTripDetailModel($workTripDetail);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('work-trip-details.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.work-trip-detail.create');
    }
}
