<?php

namespace App\Livewire\WellMasters;

use App\Models\WellMaster;
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
        $wellMasters = WellMaster::paginate();

        return view('livewire.well-master.index', compact('wellMasters'))
            ->with('i', $this->getPage() * $wellMasters->perPage());
    }

    public function delete(WellMaster $wellMaster): void
    {
        $wellMaster->delete();

        $this->redirectRoute('well-masters.index', navigate: true);
    }
}
