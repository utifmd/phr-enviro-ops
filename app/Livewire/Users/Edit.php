<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use App\Repositories\Contracts\ILogRepository;
use App\Repositories\Contracts\IOperatorRepository;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    protected IOperatorRepository $opRepos;
    protected ILogRepository $logRepos;
    protected IUserRepository $usrRepos;
    public UserForm $form;
    public array $operatorOptions;
    public bool $areWithPassword = false;

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

        $this->initAuth();
        $this->initOperators();
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

    private function assignLog(): void
    {
        $this->logRepos->addLogs(
            'users', 'updated user '.$this->form->name
        );
    }

    /**
     * @throws ValidationException
     */
    public function save(): void
    {
        $this->form->update();
        $this->assignLog();

        $this->redirectRoute('users.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.user.edit');
    }
}
