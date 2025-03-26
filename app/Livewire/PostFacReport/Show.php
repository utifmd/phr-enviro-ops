<?php

namespace App\Livewire\PostFacReport;

use App\Livewire\Forms\WorkTripForm;
use App\Models\PostFacReport;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public WorkTripForm $form;

    public function mount(PostFacReport $workTrip)
    {
        $this->form->setWorkTripModel($workTrip);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.post-fac-report.show', ['workTrip' => $this->form->workTripModel]);
    }
}
