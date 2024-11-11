<?php

namespace App\Livewire\Orders;

use App\Livewire\Forms\OrderForm;
use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public OrderForm $form;

    public function mount(Order $order)
    {
        $this->form->setOrderModel($order);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.order.show', ['order' => $this->form->orderModel]);
    }
}
