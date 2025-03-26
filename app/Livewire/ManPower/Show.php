<?php

namespace App\Livewire\ManPower;

use App\Livewire\Forms\CrewForm;
use App\Models\ManPower;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public CrewForm $form;

    public function mount(ManPower $crew)
    {
        $this->form->setCrewModel($crew);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.man-power.show', ['crew' => $this->form->crewModel]);
    }
}
