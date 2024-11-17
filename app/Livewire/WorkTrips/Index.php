<?php

namespace App\Livewire\WorkTrips;

use App\Models\WorkTrip;
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
        $workTrips = WorkTrip::paginate();

        return view('livewire.work-trip.index', compact('workTrips'))
            ->with('i', $this->getPage() * $workTrips->perPage());
    }

    public function delete(WorkTrip $workTrip)
    {
        $workTrip->delete();

        return $this->redirectRoute('work-trips.index', navigate: true);
    }
}
