<?php

namespace App\Livewire\Activities;

use App\Livewire\Forms\ActivityForm;
use App\Models\Activity;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public ActivityForm $form;

    public function mount(Activity $activity)
    {
        $this->form->setActivityModel($activity);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.activity.show', ['activity' => $this->form->activityModel]);
    }
}
