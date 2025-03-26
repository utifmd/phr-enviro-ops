<?php

namespace App\Livewire\PostWoInfo;

use App\Livewire\Actions\GetStep;
use App\Livewire\Forms\InformationForm;
use App\Models\Information;
use App\Models\PostWoPlanOrder;
use App\Repositories\Contracts\ICrewRepository;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\IOperatorRepository;
use App\Repositories\Contracts\IUserCurrentPostRepository;
use App\Repositories\Contracts\IVehicleRepository;
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
    public array $operators;
    public array $vehicles;
    // public array $vehicleTypes;
    public array $crews;
    public string $postId;
    public array $steps;
    public int $stepAt;
    public bool $disabled;
    public bool $isEditMode = false;

    public function __construct()
    {
        $user = auth()->user();
        $this->userId = $user->getAuthIdentifier();
        if ($currentPost = $user->currentPost ?? false){

            $this->postId = $currentPost->post_id;
        }
        $getStep = new GetStep($user);
        $this->steps = $getStep->getSteps();
        $this->stepAt = $getStep->getStepAt();
        $this->disabled = false; // in_array(PostWoInfo::ROUTE_POS, $this->steps) && $this->stepAt != PostWoInfo::ROUTE_POS;
    }

    public function mount(Information $information): void
    {
        $builder = Information::query()
            ->where('post_id', '=', $this->postId)
            ->get();
        $model = $information;

        if ($builder->isNotEmpty()) {
            $model = $builder->first();
            $this->isEditMode = true;
        }
        $model->post_id = $this->postId;
        $this->form->setInformationModel($model);
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
        // $this->vehicleTypes = $operatorRepos->getVehicleTypesOptions();
        $this->onOperatorIdInit();
    }

    public function onOperatorIdChange(): void {
        $this->onOperatorIdInit();

        $this->form->reset('vehicle_id', 'crew_id');
    }
    public function onOperatorIdInit(): void
    {
        $this->vehicles = $this->vehicleRepos
            ->getVehiclesOptions($this->form->operator_id);

        $this->crews = $this->crewRepos
            ->getCrewsOptions($this->form->operator_id);
    }

    public function onVehicleChange(): void
    {
        $vehicle = $this->form->informationModel->vehicle;
        $this->form->vehicle_type = $vehicle->vehicleClass->name;
    }

    public function addInformationThenNextToOrder(): void
    {
        $this->form->store();
        $userCurrentPost = [
            'steps' => '0;1;2',
            'step_at' => PostWoPlanOrder::ROUTE_POS,
            'url' => PostWoPlanOrder::ROUTE_NAME . '.create'
        ];
        $this->userCurrentPostRepos->update($this->userId, $userCurrentPost);
        session()->flash(
            'message', 'PostWoInfo successfully submitted, please follow the next step!'
        );
        $this->redirectRoute($userCurrentPost['url'], navigate: true);
    }

    public function changeInformation(): void
    {
        $this->form->update();

        session()->flash('message',
            'PostWoInfo successfully updated, please follow the next step!'
        );
    }

    public function save(): void
    {
        $this->form->store();

        $this->redirectRoute('information.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        if ($this->isEditMode)
            return view('livewire.information.edit');

        return view('livewire.information.create');
    }
}
