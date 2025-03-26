<?php

namespace App\Livewire\Vehicles;

use App\Livewire\Forms\VehicleForm;
use App\Models\Vehicle;
use App\Repositories\Contracts\ILogRepository;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class Create extends Component
{
    protected ILogRepository $logRepos;
    public VehicleForm $form;
    #[Url]
    public ?string $operatorId = null;

    public function boot(ILogRepository $logRepos): void
    {
        $this->logRepos = $logRepos;
    }

    public function mount(Vehicle $vehicle): void
    {
        $vehicle->company_id = $this->operatorId;
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
        $this->form->store();
        $this->assignLog();

        $this->redirect('/operators/show/'.$this->operatorId, navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.vehicle.create');
    }
}
