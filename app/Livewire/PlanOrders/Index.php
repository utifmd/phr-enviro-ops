<?php

namespace App\Livewire\PlanOrders;

use App\Models\PlanOrder;
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
        $planOrder = PlanOrder::paginate();

        return view('livewire.order.index', compact('planOrder'))
            ->with('i', $this->getPage() * $planOrder->perPage());
    }

    public function delete(PlanOrder $order): void
    {
        $order->delete();

        $this->redirectRoute(PlanOrder::ROUTE_NAME.'.index', navigate: true);
    }
}
