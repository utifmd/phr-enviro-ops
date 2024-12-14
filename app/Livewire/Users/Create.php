<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use App\Repositories\Contracts\IOperatorRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    protected IOperatorRepository $opRepos;
    public UserForm $form;
    public array $operatorOptions;

    public function mount(User $user): void
    {
        $this->form->setUserModel($user);

        $this->initOperators();
    }

    public function boot(IOperatorRepository $opRepos): void
    {
        $this->opRepos = $opRepos;
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

        $this->redirectRoute('users.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.user.create');
    }
}
