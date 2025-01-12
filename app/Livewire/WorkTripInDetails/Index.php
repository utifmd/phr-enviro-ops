<?php

namespace App\Livewire\WorkTripInDetails;

use App\Models\WorkTripInDetail;
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
        $workTripDetails = WorkTripInDetail::query()->where('area_name', auth()->user()->area_name)->paginate();

        return view('livewire.work-trip-in-detail.index', compact('workTripDetails'))
            ->with('i', $this->getPage() * $workTripDetails->perPage());
    }

    public function delete(WorkTripInDetail $workTripDetail)
    {
        $workTripDetail->delete();

        return $this->redirectRoute('work-trip-in-details.index', navigate: true);
    }
}
