<?php

namespace App\Livewire\PostWoPlanOrder;

use App\Livewire\Forms\PlanOrderForm;
use App\Models\PostWoPlanOrder;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public PlanOrderForm $form;

    public function mount(PostWoPlanOrder $order): void
    {
        $this->form->setPlanOrder($order);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.'.PostWoPlanOrder::ROUTE_NAME.'.show', ['order' => $this->form->planOrder]);
    }
}
