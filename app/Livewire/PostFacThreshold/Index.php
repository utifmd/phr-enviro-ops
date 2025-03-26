<?php

namespace App\Livewire\PostFacThreshold;

use App\Models\PostFacThreshold;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActUnitEnum;
use App\Utils\AreaNameEnum;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected IWorkTripRepository $workTripRepos;
    protected IUserRepository $usrRepos;
    public array $authUsr;

    protected LengthAwarePaginator $groupedInfoState;

    public function boot(
        IWorkTripRepository $workTripRepos, IUserRepository $usrRepos): void
    {
        $this->workTripRepos = $workTripRepos;
        $this->usrRepos = $usrRepos;
    }

    public function mount(): void
    {
        $this->initAuthUser();
        $this->initInfoState();
    }

    public function hydrate(): void
    {
        $this->initInfoState();
    }

    private function initAuthUser(): void
    {
        $this->authUsr = $this->usrRepos->authenticatedUser()->toArray();
    }

    private function initInfoState(): void
    {
        $this->groupedInfoState = $this->workTripRepos->sumInfoByArea(
            $this->authUsr['area_name']
        );
    }

    public function delete(string $date): void
    {
        $this->workTripRepos->deleteThresholdBy($date);

        $this->redirectRoute('post-fac-threshold.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $infoState = $this->groupedInfoState;
        return view('livewire.post-fac-threshold.index', compact('infoState'))
            ->with('i', $this->getPage() * $infoState->perPage());
    }
}
