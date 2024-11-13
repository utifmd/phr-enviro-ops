<?php

namespace App\Livewire\Operators;

use App\Livewire\Forms\OperatorForm;
use App\Models\Crew;
use App\Models\Operator;
use App\Utils\Enums\CrewRoleEnum;
use App\Utils\Enums\VehicleTypeEnum;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public Operator $operator;
    public Collection $crews;
    public Collection $vehicles;
    public OperatorForm $form;

    public function mount(Operator $operator): void
    {
        $this->operator = $operator;
        $this->crews = $this->operator->crews;
        $this->vehicles = $this->operator->vehicles;

        $this->crews = $this->mappedCrews($this->crews);
        $this->vehicles = $this->mappedVehicles($this->vehicles);
        $this->form->setOperatorModel($operator);
    }

    private function mappedCrews($data)
    {
        return $data->map(function ($crew) {
            $crew->role = collect(CrewRoleEnum::cases())
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
        return view('livewire.operator.detail');
    }
}
