<?php

namespace App\Livewire\TripPlans;

use App\Models\TripPlan;
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
        $tripPlans = TripPlan::paginate();

        return view('livewire.trip-plan.index', compact('tripPlans'))
            ->with('i', $this->getPage() * $tripPlans->perPage());
    }

    public function delete(TripPlan $tripPlan)
    {
        $tripPlan->delete();

        return $this->redirectRoute('trip-plans.index', navigate: true);
    }
}
