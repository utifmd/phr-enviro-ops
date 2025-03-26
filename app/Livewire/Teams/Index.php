<?php

namespace App\Livewire\Teams;

use App\Models\Team;
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
        $departments = Team::paginate();

        return view('livewire.team.index', compact('departments'))
            ->with('i', $this->getPage() * $departments->perPage());
    }

    public function delete(Team $department)
    {
        $department->delete();

        return $this->redirectRoute('teams.index', navigate: true);
    }
}
