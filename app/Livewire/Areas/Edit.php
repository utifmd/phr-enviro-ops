<?php

namespace App\Livewire\Areas;

use App\Livewire\Forms\AreaForm;
use App\Models\Area;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public AreaForm $form;

    public function mount(Area $area)
    {
        $this->form->setAreaModel($area);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('areas.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.area.edit');
    }
}
