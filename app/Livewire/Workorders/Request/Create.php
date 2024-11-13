<?php

namespace App\Livewire\Workorders\Request;

use App\Models\WorkOrder;
use App\Service\Contracts\IWellService;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public function booted(IWellService $service): void
    {
    }

    public function mount(?string $woNumber = null): void
    {
    }
    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.'.WorkOrder::ROUTE_NAME.'request.create');
    }
}
