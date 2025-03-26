<?php

namespace App\Livewire\PostWoPlanOrder;

use App\Models\PostWoPlanOrder;
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
        $planOrder = PostWoPlanOrder::paginate();

        return view('livewire.order.index', compact('planOrder'))
            ->with('i', $this->getPage() * $planOrder->perPage());
    }

    public function delete(PostWoPlanOrder $order): void
    {
        $order->delete();

        $this->redirectRoute(PostWoPlanOrder::ROUTE_NAME.'.index', navigate: true);
    }
}
