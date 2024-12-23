<?php

namespace App\Livewire\Areas;

use App\Models\Area;
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
        $areas = Area::paginate();

        return view('livewire.area.index', compact('areas'))
            ->with('i', $this->getPage() * $areas->perPage());
    }

    public function delete(Area $area)
    {
        $area->delete();

        return $this->redirectRoute('areas.index', navigate: true);
    }
}
