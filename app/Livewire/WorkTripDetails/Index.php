<?php

namespace App\Livewire\WorkTripDetails;

use App\Models\WorkTripDetail;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]
    public function render(): View
    {
        $workTripDetails = WorkTripDetail::paginate();

        return view('livewire.work-trip-detail.index', compact('workTripDetails'))
            ->with('i', $this->getPage() * $workTripDetails->perPage());
    }

    public function delete(WorkTripDetail $workTripDetail)
    {
        $workTripDetail->delete();

        return $this->redirectRoute('work-trip-details.index', navigate: true);
    }
}
