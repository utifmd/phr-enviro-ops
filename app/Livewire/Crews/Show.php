<?php

namespace App\Livewire\Crews;

use App\Livewire\Forms\CrewForm;
use App\Models\Crew;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public CrewForm $form;

    public function mount(Crew $crew)
    {
        $this->form->setCrewModel($crew);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.crew.show', ['crew' => $this->form->crewModel]);
    }
}
