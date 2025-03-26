<?php

namespace App\Livewire\PostFacReport;

use App\Models\PostFacReport;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\AreaNameEnum;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function mount(
        IWorkTripRepository $workTripRepos, IUserRepository $usrRepos): void
    {
        $this->workTripRepos = $workTripRepos;
        $this->usrRepos = $usrRepos;
        $this->initAuthUser();
        $this->initInfoState();
    }

    public function hydrate(
        IWorkTripRepository $workTripRepos, IUserRepository $usrRepos): void
    {
        $this->workTripRepos = $workTripRepos;
        $this->usrRepos = $usrRepos;
    }

    private function initInfoState(): void
    {
        $this->groupedInfoState = $this->workTripRepos
            ->sumInfoAndTripByArea($this->authUsr['area_name']);
    }

    private function initAuthUser(): void
    {
        $this->authUsr = $this->usrRepos->authenticatedUser()->toArray();
    }

    public function delete(string $date): void
    {
        /*$workTripInfo->delete();

        $this->redirectRoute('post-fac-threshold.index', navigate: true);*/
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $infoState = $this->groupedInfoState;
        return view('livewire.post-fac-report.index', compact('infoState'))
            ->with('i', $this->getPage() * $infoState->perPage());
    }
}

