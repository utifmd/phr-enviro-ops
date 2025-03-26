<?php

namespace App\Livewire\PostWoInfo;

use App\Models\Information;
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
        $information = Information::paginate();

        return view('livewire.information.index', compact('information'))
            ->with('i', $this->getPage() * $information->perPage());
    }

    public function delete(Information $information): void
    {
        $information->delete();

        $this->redirectRoute('information.index', navigate: true);
    }
}
