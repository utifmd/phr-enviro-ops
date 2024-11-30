<?php

namespace App\Livewire\WorkTripInfos;

use App\Models\WorkTripInfo;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActUnitEnum;
use App\Utils\AreaNameEnum;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected IWorkTripRepository $workTripRepos;
    protected string $authId;

    protected LengthAwarePaginator $groupedInfoState;

    public function mount(IWorkTripRepository $workTripRepos): void
    {
        $this->authId = auth()->id();
        $this->workTripRepos = $workTripRepos;
        $this->initInfoState();
    }

    public function hydrate(IWorkTripRepository $workTripRepos): void
    {
        $this->workTripRepos = $workTripRepos;
        $this->initInfoState();
    }

    private function initInfoState(): void
    {
        $this->groupedInfoState = $this->workTripRepos->sumInfoByArea(AreaNameEnum::MINAS->value);
    }

    public function delete(string $date): void
    {
        /*$workTripInfo->delete();

        $this->redirectRoute('work-trip-infos.index', navigate: true);*/
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $infoState = $this->groupedInfoState;
        return view('livewire.work-trip-info.index', compact('infoState'))
            ->with('i', $this->getPage() * $infoState->perPage());
    }
}
