<?php

namespace App\Livewire\PostFac;

use App\Models\PostFac;
use App\Repositories\Contracts\ILogRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActNameEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
class Index extends Component
{
    use WithPagination;
    protected IWorkTripRepository $wtRepos;
    protected IUserRepository $usrRepos;
    protected ILogRepository $logRepos;
    protected LengthAwarePaginator $detailsByArea;
    public array $authUsr;
    public string $date, $type;

    public function boot(
        ILogRepository $logRepos, IUserRepository $usrRepos, IWorkTripRepository $wtRepos): void
    {
        $this->logRepos = $logRepos;
        $this->usrRepos = $usrRepos;
        $this->wtRepos = $wtRepos;
    }
    public function mount(): void
    {
        $this->date = date('Y-m-d');
        $this->type = ActNameEnum::Incoming->value;

        $this->initAuthUser();
        $this->initWorkTripDetails();
    }

    public function hydrate(): void
    {
        $this->initWorkTripDetails();
    }

    private function initAuthUser(): void
    {
        $this->authUsr = $this->usrRepos->authenticatedUser()->toArray();
    }
    private function initWorkTripDetails(): void
    {
        $this->detailsByArea = $this->wtRepos->detailBuilder($this->date)
            ->where('area_name', $this->authUsr['area_name'])
            ->where('type', $this->type)
            ->orderByDesc('created_at')
            ->paginate();

    }
    public function onDateChange(): void
    {
        $this->initWorkTripDetails();
    }

    public function onTypeChange(): void
    {
        $this->initWorkTripDetails();
    }

    public function delete(PostFac $workTripDetail): void
    {
        $workTripDetail->delete();

        $this->redirectRoute('post-fac.index', navigate: true);
    }
    #[Layout('layouts.app')]
    public function render(): View
    {
        $workTripDetails = $this->detailsByArea;

        return view('livewire.post-fac.index', compact('workTripDetails'))
            ->with('i', $this->getPage() * $workTripDetails->perPage());
    }
}
