<?php

namespace App\Livewire\PostFac;

use App\Livewire\Forms\WorkTripDetailForm;
use App\Models\PostFac;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public WorkTripDetailForm $form;

    public function mount(PostFac $workTripDetail)
    {
        $this->form->setWorkTripDetailModel($workTripDetail);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('post-fac.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post-fac.edit');
    }
}
