<?php

namespace App\Livewire\Logs;

use App\Models\Log;
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
        $logs = Log::paginate();

        return view('livewire.log.index', compact('logs'))
            ->with('i', $this->getPage() * $logs->perPage());
    }

    public function delete(Log $log)
    {
        $log->delete();

        return $this->redirectRoute('logs.index', navigate: true);
    }
}
