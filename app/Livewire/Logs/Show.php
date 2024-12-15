<?php

namespace App\Livewire\Logs;

use App\Livewire\Forms\LogForm;
use App\Models\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public LogForm $form;

    public function mount(Log $log)
    {
        $this->form->setLogModel($log);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.log.show', ['log' => $this->form->logModel]);
    }
}
