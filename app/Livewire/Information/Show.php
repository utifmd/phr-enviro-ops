<?php

namespace App\Livewire\Information;

use App\Livewire\Forms\InformationForm;
use App\Models\Information;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public InformationForm $form;

    public function mount(Information $information)
    {
        $this->form->setInformationModel($information);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.information.show', ['information' => $this->form->informationModel]);
    }
}
