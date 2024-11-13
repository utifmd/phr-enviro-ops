<?php

namespace App\Livewire\PlanOrders;

use App\Livewire\Forms\PlanOrderForm;
use App\Models\PlanOrder;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public PlanOrderForm $form;

    public function mount(PlanOrder $order): void
    {
        $this->form->setPlanOrder($order);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.'.PlanOrder::ROUTE_NAME.'.show', ['order' => $this->form->planOrder]);
    }
}
