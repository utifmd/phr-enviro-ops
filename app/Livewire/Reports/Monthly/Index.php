<?php

namespace App\Livewire\Reports\Monthly;

use App\Livewire\BaseComponent;
use Illuminate\View\View;
use Livewire\Attributes\Layout;

class Index extends BaseComponent
{
    public function boot(): void
    {

    }

    public function mount(): void
    {

    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.report.monthly');
    }
}
