<?php

namespace App\Livewire\WorkTripInfos;

use App\Models\WorkTripInfo;
use App\Utils\ActUnitEnum;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected string $authId;
    public Collection $groupedInfoState;

    public function mount(): void
    {
        $this->authId = auth()->id();

        $this->initInfoState();
    }

    private function initInfoState(): void
    {
        $this->groupedInfoState = WorkTripInfo::query()
            ->selectRaw('date, act_unit, SUM(act_value) AS act_value_sum')
            ->where('user_id', '=', $this->authId, 'and')
            /*->where('act_unit', '=', ActUnitEnum::LOAD->value)*/
            ->groupBy('date', 'act_unit')
            ->get();
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $workTripInfos = WorkTripInfo::paginate();

        return view('livewire.work-trip-info.index', compact('workTripInfos'))
            ->with('i', $this->getPage() * $workTripInfos->perPage());
    }

    public function delete(string $date): void
    {
        /*$workTripInfo->delete();

        $this->redirectRoute('work-trip-infos.index', navigate: true);*/
    }
}
