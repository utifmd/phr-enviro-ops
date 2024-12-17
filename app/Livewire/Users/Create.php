<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use App\Repositories\Contracts\ILogRepository;
use App\Repositories\Contracts\IOperatorRepository;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    protected ILogRepository $logRepos;
    protected IUserRepository $usrRepos;
    protected IOperatorRepository $opRepos;
    public UserForm $form;
    public array $operatorOptions;
    public bool $areWithPassword = true;

    public function boot(
        ILogRepository $logRepos,
        IUserRepository $usrRepos,
        IOperatorRepository $opRepos): void
    {
        $this->usrRepos = $usrRepos;
        $this->logRepos = $logRepos;
        $this->opRepos = $opRepos;
    }

    public function mount(User $user): void
    {
        $this->form->setUserModel($user);

        $this->initOperators();
        $this->initAuth();
    }

    private function assignLog(): void
    {
        $this->logRepos->addLogs(
            'users', 'updated user '.$this->form->name
        );
    }

    private function initOperators(): void
    {
        $this->operatorOptions = $this->opRepos->getOperatorsOptions();
    }

    private function initAuth(): void
    {
        $authUser = $this->usrRepos->authenticatedUser();
        $this->form->area_name = $authUser->area_name;
    }

    /**
     * @throws ValidationException
     */
    public function save(): void
    {
        $this->form->store();
        $this->assignLog();

        $this->redirectRoute('users.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.user.create');
    }
}
