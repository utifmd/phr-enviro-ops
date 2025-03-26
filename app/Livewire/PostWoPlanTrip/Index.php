<?php

namespace App\Livewire\PostWoPlanTrip;

use App\Models\PostWoPlanTrip;
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
        $tripPlans = PostWoPlanTrip::paginate();

        return view('livewire.trip-plan.index', compact('tripPlans'))
            ->with('i', $this->getPage() * $tripPlans->perPage());
    }

    public function delete(PostWoPlanTrip $tripPlan): void
    {
        $tripPlan->delete();

        $this->redirectRoute(PostWoPlanTrip::ROUTE_NAME.'.index', navigate: true);
    }
}
