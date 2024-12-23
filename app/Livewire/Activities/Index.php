<?php

namespace App\Livewire\Activities;

use App\Models\Activity;
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
        $activities = Activity::paginate();

        return view('livewire.activity.index', compact('activities'))
            ->with('i', $this->getPage() * $activities->perPage());
    }

    public function delete(Activity $activity)
    {
        $activity->delete();

        return $this->redirectRoute('activities.index', navigate: true);
    }
}
