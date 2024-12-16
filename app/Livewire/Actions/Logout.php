<?php

namespace App\Livewire\Actions;

use App\Repositories\Contracts\ILogRepository;
use App\Utils\AreaNameEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    protected ILogRepository $logRepos;
    /**
     * Log the current user out of the application.
     */
    public function __construct(ILogRepository $logRepos)
    {
        $this->logRepos = $logRepos;
    }

    public function __invoke(): void
    {
        $this->logRepos->addLogs(
            'profile', 'signed out'
        );
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();
    }
}
