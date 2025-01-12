<?php

namespace App\Livewire\WorkTripOutDetails;

use App\Models\WorkTripOutDetail;
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
        $workTripOutDetails = WorkTripOutDetail::paginate();

        return view('livewire.work-trip-out-detail.index', compact('workTripOutDetails'))
            ->with('i', $this->getPage() * $workTripOutDetails->perPage());
    }

    public function delete(WorkTripOutDetail $workTripOutDetail)
    {
        $workTripOutDetail->delete();

        return $this->redirectRoute('work-trip-out-details.index', navigate: true);
    }
}
