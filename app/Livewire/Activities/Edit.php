<?php

namespace App\Livewire\Activities;

use App\Livewire\Forms\ActivityForm;
use App\Models\Activity;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public ActivityForm $form;

    public function mount(Activity $activity)
    {
        $this->form->setActivityModel($activity);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('activities.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.activity.edit');
    }
}
