<?php

namespace App\Livewire\ManPower;

use App\Models\ManPower;
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
        $crews = ManPower::paginate();

        return view('livewire.man-power.index', compact('crews'))
            ->with('i', $this->getPage() * $crews->perPage());
    }

    public function delete(ManPower $crew)
    {
        $crew->delete();

        return $this->redirectRoute('man-power.index', navigate: true);
    }
}
