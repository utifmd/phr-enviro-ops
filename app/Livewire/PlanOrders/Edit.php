<?php

namespace App\Livewire\PlanOrders;

use App\Livewire\Forms\PlanOrderForm;
use App\Models\PlanOrder;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public PlanOrderForm $form;

    public function mount(PlanOrder $order): void
    {
        $this->form->setPlanOrder($order);
    }

    public function save(): void
    {
        $this->form->update();

        $this->redirectRoute(PlanOrder::ROUTE_NAME.'.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.'.PlanOrder::ROUTE_NAME.'.edit');
    }
}
