<?php

namespace App\Livewire\Crews;

use App\Models\Crew;
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
        $crews = Crew::paginate();

        return view('livewire.crew.index', compact('crews'))
            ->with('i', $this->getPage() * $crews->perPage());
    }

    public function delete(Crew $crew)
    {
        $crew->delete();

        return $this->redirectRoute('crews.index', navigate: true);
    }
}
