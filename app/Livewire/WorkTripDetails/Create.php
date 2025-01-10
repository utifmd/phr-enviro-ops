<?php

namespace App\Livewire\WorkTripDetails;

use App\Livewire\Forms\WorkTripDetailForm;
use App\Mapper\Contracts\IWorkTripMapper;
use App\Models\WorkTripDetail;
use App\Repositories\Contracts\ICrewRepository;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\ILogRepository;
use App\Repositories\Contracts\IOperatorRepository;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IVehicleRepository;
use App\Repositories\Contracts\IWellMasterRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\Constants;
use App\Utils\Contracts\IUtility;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    protected IDBRepository $dbRepos;
    protected ILogRepository $logRepos;
    protected IUtility $util;
    protected IUserRepository $usrRepos;
    protected IPostRepository $pstRepos;
    protected IWorkTripRepository $wtRepos;
    protected IWorkTripMapper $wtMapper;
    protected IWellMasterRepository $wellRepos;
    protected IOperatorRepository $opeRepos;
    protected IVehicleRepository $vehRepos;
    protected ICrewRepository $crewRepos;

    public WorkTripDetailForm $form;

    public array $timeOptions, $authUsr, $wells,
        $operators, $vehicles, $crews, $facilities;

    public string $currentDate, $well;
    public bool $isEditMode = false;

    public function boot(
        IDBRepository $dbRepos,
        ILogRepository $logRepos,
        IUtility $util,
        IWorkTripMapper $wtMapper,
        IUserRepository $usrRepos,
        IPostRepository $pstRepos,
        IWorkTripRepository $wtRepos,
        IWellMasterRepository $wellRepos,
        IOperatorRepository $opeRepos,
        IVehicleRepository $vehRepos,
        ICrewRepository $crewRepos): void
    {
        $this->dbRepos = $dbRepos;
        $this->opeRepos = $opeRepos;
        $this->logRepos = $logRepos;
        $this->util = $util;
        $this->wtMapper = $wtMapper;
        $this->usrRepos = $usrRepos;
        $this->wtRepos = $wtRepos;
        $this->pstRepos = $pstRepos;
        $this->wellRepos = $wellRepos;
        $this->crewRepos = $crewRepos;
        $this->vehRepos = $vehRepos;
    }

    public function mount(WorkTripDetail $tripDetail): void
    {
        $this->form->setWorkTripDetailModel($tripDetail);

        $this->initAuthUser();
        $this->initDateOptions();
        $this->initAreas();
        $this->initWells();
        $this->initOperators();
        $this->initVehicles();
        $this->initCrews();
        $this->initTimeOptions();
        $this->initLocOptions();
        $this->initDetail();
    }

    public function hydrate(): void
    {
        $this->initAuthUser();
    }

    private function initAuthUser(): void
    {
        $this->authUsr = $this->usrRepos->authenticatedUser()->toArray();
        $this->form->user_id = $this->authUsr['id'];
    }

    /**
     * @throws ValidationException
     */
    public function check(): void
    {
        $this->form->validate();
        $message = json_encode($this->form->toArray());
        // Log::debug($message);
        $this->addError('error', $message);
    }

    private function initAreas(): void
    {
        $this->facilities = $this->wtRepos->getLocationsOptions(
            $this->authUsr['area_name']
        );
    }

    private function initOperators(): void
    {
        $this->operators = $this->opeRepos->getOperatorsOptions();
    }

    private function initVehicles(): void
    {
        $this->vehicles = $this->vehRepos->getVehiclesOptions(
            $this->authUsr['operator_id']
        );
    }

    private function initCrews(): void
    {
        $this->crews = $this->crewRepos->getCrewsOptions(
            $this->authUsr['operator_id']
        );
    }

    private function initWells(): void
    {
        $this->well = Constants::EMPTY_STRING;
        $this->searchWellBy($this->well);
    }

    private function initDateOptions(): void
    {
        $this->currentDate = date('Y-m-d');
        $this->form->created_at = $this->currentDate;
    }

    private function initTimeOptions(): void
    {
        $this->timeOptions = $this->util
            ->getListOfTimesOptions(0, 22);

        $formTimeSession = session('form_time');
        $options = $formTimeSession
            ?? $this->timeOptions[0]['value'] ?? Constants::EMPTY_STRING;

        $this->form->time_in = $options;
        $this->form->time_out = $options;
    }

    private function initLocOptions(): void
    {
        $areaName = $this->authUsr['area_name'] ?? null;
        if (is_null($areaName)) return;

        $this->form->area_name = $areaName;
    }

    private function initDetail(): void
    {
        $this->form->setWorkTripDetailModel(new WorkTripDetail(array()));

        $operator = $this->authUsr['operator'];
        $this->form->transporter = trim(
            $operator['prefix'].' '.$operator['name'].' '.$operator['postfix']
        );
        $this->form->time_out = $this->form->time_in;
        $this->assignPost();
    }

    public function onTimeOptionChange(): void
    {
        $this->form->time_out = $this->form->time_in;
    }

    private function assignPost(): void
    {
        $post = $this->pstRepos
            ->postByDateBuilder($this->currentDate)
            ->whereHas('user', fn ($query) => $query->where('area_name', $this->authUsr['area_name']));

        $postId = $post->first()->id
            ?? $this->pstRepos->generatePost($this->authUsr);

        $this->form->post_id = $postId;
    }

    public function searchWellBy(?string $query = null): void
    {
        $this->wells = $this->wellRepos
            ->getWellMastersByQuery($query ?? $this->well)
            ->toArray();
    }
    public function save(): void
    {
        $this->form->store();

        $this->redirectRoute('work-trip-details.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip-detail.create');
    }
}
