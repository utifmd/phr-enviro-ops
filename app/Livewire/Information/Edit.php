<?php

namespace App\Livewire\Information;

use App\Livewire\Forms\InformationForm;
use App\Models\Information;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public InformationForm $form;

    public function mount(Information $information): void
    {
        $this->form->setInformationModel($information);
    }

    public function save(): void
    {
        $this->form->update();

        $this->redirectRoute('information.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.information.edit');
    }
}
