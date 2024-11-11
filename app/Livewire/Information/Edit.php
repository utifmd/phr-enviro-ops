<?php

namespace App\Livewire\Information;

use App\Livewire\Forms\InformationForm;
use App\Models\Information;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public InformationForm $form;

    public function mount(Information $information)
    {
        $this->form->setInformationModel($information);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('information.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.information.edit');
    }
}
