<?php

namespace App\Livewire\Logs;

use App\Livewire\Forms\LogForm;
use App\Models\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public LogForm $form;

    public function mount(Log $log)
    {
        $this->form->setLogModel($log);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('logs.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.log.create');
    }
}
