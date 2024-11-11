<?php

namespace App\Livewire\Information;

use App\Livewire\Actions\GetStep;
use App\Livewire\Actions\UpdateUserCurrentPost;
use App\Livewire\Forms\InformationForm;
use App\Models\Information;
use App\Models\Order;
use App\Repositories\Contracts\ICrewRepository;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\IOperatorRepository;
use App\Repositories\Contracts\IUserCurrentPostRepository;
use App\Repositories\Contracts\IVehicleRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    protected IDBRepository $dbRepos;
    protected IVehicleRepository $vehicleRepos;
    protected ICrewRepository $crewRepos;
    protected IUserCurrentPostRepository $userCurrentPostRepos;
    private string $userId;

    public InformationForm $form;
    public ?Collection $operators = null;
    public ?Collection $vehicles = null;
    public ?Collection $crews = null;
    public string $postId;
    public array $steps;
    public int $stepAt;
    public bool $disabled;

    public function __construct()
    {
        $user = auth()->user();
        $this->userId = $user->getAuthIdentifier();
        $getStep = new GetStep($user);
        if ($currentPost = $user->currentPost ?? false){

            $this->postId = $currentPost->post_id;
        }
        $this->steps = $getStep->getSteps();
        $this->stepAt = $getStep->getStepAt();
        $this->disabled = in_array(Information::ROUTE_POS, $this->steps) &&
            $this->stepAt != Information::ROUTE_POS;
    }

    public function mount(Information $information): void
    {
        $build = Information::query()
            ->where('post_id', '=', $this->postId)
            ->get();

        $informationModel = $build->isNotEmpty()
            ? $build->first()
            : $information;

        $informationModel->post_id = $this->postId;
        $this->form->setInformationModel($informationModel);
    }

    public function booted(
        IDBRepository $dbRepos,
        IUserCurrentPostRepository $userCurrentPostRepos,
        IOperatorRepository $operatorRepos,
        IVehicleRepository $vehicleRepos,
        ICrewRepository $crewRepos): void
    {
        $this->dbRepos = $dbRepos;
        $this->userCurrentPostRepos = $userCurrentPostRepos;
        $this->vehicleRepos = $vehicleRepos;
        $this->crewRepos = $crewRepos;

        $this->operators = $operatorRepos->getOperatorsOptions();
        $this->onOperatorIdChange();
    }

    public function onOperatorIdChange(): void
    {
        $this->vehicles = $this->vehicleRepos
            ->getVehiclesOptions($this->form->operator_id);

        $this->crews = $this->crewRepos
            ->getCrewsOptions($this->form->operator_id);
    }

    public function save(): void
    {
        $this->form->store();

        $this->redirectRoute('information.index', navigate: true);
    }

    public function addInformationThenNextToOrder(): void
    {
        try {
            $this->dbRepos->async();
            $this->form->store();
            $userCurrentPost = [
                'steps' => '0;1;2',
                'step_at' => Order::ROUTE_POS,
                'url' => Order::ROUTE_NAME . '.create'
            ];
            $this->userCurrentPostRepos->update(
                $this->userId, $userCurrentPost
            );
            session()->flash(
                'message', 'Information successfully submitted, please follow the next step!'
            );
            $this->redirectRoute($userCurrentPost['url'], navigate: true);
            $this->dbRepos->await();

        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            session()->flash('message', $message);

            Log::error($message);
            $this->dbRepos->cancel();
        }
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.information.create');
    }
}
