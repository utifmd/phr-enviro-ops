<?php

namespace App\Livewire\Logs;

use App\Livewire\Forms\LogForm;
use App\Models\Log;
use App\Repositories\Contracts\ILogRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Utils\AreaNameEnum;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected ILogRepository $logRepos;
    protected IUserRepository $usrRepos;
    protected LengthAwarePaginator $pagedLogs;
    public LogForm $logForm;
    public array $authUsr;
    public string $areaName;

    public function boot(
        ILogRepository $logRepos, IUserRepository $usrRepos): void
    {
        $this->logRepos = $logRepos;
        $this->usrRepos = $usrRepos;
    }

    public function mount(Log $log): void
    {
        $this->logForm->setLogModel($log);

        $this->initAuthUser();
        $this->initLogs();
    }

    public function hydrate(): void
    {
        $this->initLogs();
    }

    private function initAuthUser(): void
    {
        $this->authUsr = $this->usrRepos->authenticatedUser()->toArray();
        $this->areaName = $this->authUsr['area_name'];
    }

    private function initLogs(): void
    {
        $this->areaName = $this->authUsr['area_name'];
        if ($this->areaName == AreaNameEnum::AllArea->value) {

            $this->pagedLogs = $this->logRepos->getLogs();
            return;
        }
        $this->pagedLogs = $this->logRepos->getLogsByArea($this->areaName);
    }

    public function delete(Log $log): void
    {
        $log->delete();

        $this->redirectRoute('logs.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $logs = $this->pagedLogs;

        return view('livewire.log.index', compact('logs'))
            ->with('i', $this->getPage() * $logs->perPage());
    }
}
