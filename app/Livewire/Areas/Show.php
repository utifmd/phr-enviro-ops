<?php

namespace App\Livewire\Areas;

use App\Livewire\Forms\AreaForm;
use App\Models\Area;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public AreaForm $form;

    public function mount(Area $area)
    {
        $this->form->setAreaModel($area);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.area.show', ['area' => $this->form->areaModel]);
    }
}
