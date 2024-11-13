<?php

namespace App\Livewire\Information;

use App\Livewire\Forms\InformationForm;
use App\Models\Information;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public InformationForm $form;

    public function mount(Information $information): void
    {
        $this->form->setInformationModel($information);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.information.show', ['information' => $this->form->informationModel]);
    }
}
