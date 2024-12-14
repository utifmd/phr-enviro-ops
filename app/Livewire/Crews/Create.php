<?php

namespace App\Livewire\Crews;

use App\Livewire\Forms\CrewForm;
use App\Models\Crew;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public CrewForm $form;

    public function mount(Crew $crew)
    {
        $this->form->setCrewModel($crew);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('crews.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.crew.create');
    }
}
