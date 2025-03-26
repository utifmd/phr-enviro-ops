<?php

namespace App\Livewire\Companies;

use App\Livewire\Forms\OperatorForm;
use App\Models\Company;
use App\Utils\ManPowerRoleEnum;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public Company $operator;
    public Collection $crews;
    public Collection $vehicles;
    public OperatorForm $form;

    public function mount(Company $operator): void
    {
        $this->operator = $operator;
        $this->crews = $this->operator->manPowers;
        $this->vehicles = $this->operator->vehicles;

        $this->crews = $this->mappedCrews($this->crews);
        $this->vehicles = $this->mappedVehicles($this->vehicles);
        $this->form->setOperatorModel($operator);
    }

    private function mappedCrews($data)
    {
        return $data->map(function ($crew) {
            $crew->role = collect(ManPowerRoleEnum::cases())
                ->filter(fn ($case) => $case->value == $crew->role)
                ->map(fn ($case) => ucwords(str_replace('_', ' ', strtolower($case->name))))
                ->first() ?? $crew->role;
            return $crew;
        });
    }
    private function mappedVehicles($data)
    {
        return $data->map(function ($vehicle) {
            $vehicle->type = ucwords(str_replace('_', ' ', strtolower($vehicle->type)));
            return $vehicle;
        });
    }
    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.company.detail');
    }
}
