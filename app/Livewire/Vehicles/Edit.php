<?php

namespace App\Livewire\Vehicles;

use App\Livewire\Forms\VehicleForm;
use App\Models\Vehicle;
use App\Repositories\Contracts\ILogRepository;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    protected ILogRepository $logRepos;
    public VehicleForm $form;

    public function boot(ILogRepository $logRepos): void
    {
        $this->logRepos = $logRepos;
    }

    public function mount(Vehicle $vehicle): void
    {
        $this->form->setVehicleModel($vehicle);
    }

    private function assignLog(): void
    {
        $this->logRepos->addLogs(
            'vehicles', 'updated vehicle '.$this->form->plat
        );
    }

    public function save(): void
    {
        $this->form->update();
        $this->assignLog();

        $this->redirectRoute('vehicles.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.vehicle.edit');
    }
}
