<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use App\Repositories\Contracts\ILogRepository;
use App\Repositories\Contracts\IOperatorRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    protected ILogRepository $logRepos;
    protected IOperatorRepository $opRepos;
    public UserForm $form;
    public array $operatorOptions;

    public function boot(
        ILogRepository $logRepos, IOperatorRepository $opRepos): void
    {
        $this->logRepos = $logRepos;
        $this->opRepos = $opRepos;
    }

    public function mount(User $user): void
    {
        $this->form->setUserModel($user);

        $this->initOperators();
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
