<?php

namespace App\Livewire\Orders;

use App\Models\Order;
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
        $orders = Order::paginate();

        return view('livewire.order.index', compact('orders'))
            ->with('i', $this->getPage() * $orders->perPage());
    }

    public function delete(Order $order)
    {
        $order->delete();

        return $this->redirectRoute('orders.index', navigate: true);
    }
}
