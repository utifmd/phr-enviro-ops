<?php

namespace App\Livewire\WorkTripInDetails;

use App\Livewire\Forms\WorkTripInDetailForm;
use App\Mapper\Contracts\IWorkTripMapper;
use App\Models\WorkTripDetailIn;
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

class Edit extends Component
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

    public WorkTripInDetailForm $form;

    public array $timeOptions, $authUsr, $wells, $operators,
        $vehicles, $crews, $facilities;

    public string $currentDate, $well;
    public ?string $operatorId = null;
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

    public function mount(WorkTripDetailIn $workTripInDetail): void
    {
        $this->form->setWorkTripInDetailModel($workTripInDetail);
        $this->initAuthUser();
        $this->initDateOptions();
        $this->initAreas();
        $this->initWells();
        $this->initTimeOptions();
        $this->initLocOptions();
        $this->initDetail();
        $this->initDateOptions();
        $this->initOperators();

    }

    private function initAuthUser(): void
    {
        $this->authUsr = $this->usrRepos->authenticatedUser()->toArray();
        $this->form->user_id = $this->authUsr['id'];
        $this->form->area_name = $this->authUsr['area_name'];
    }

    private function initAreas(): void
    {
        $this->facilities = $this->wtRepos->getLocationsOptions(
            $this->authUsr['area_name']
        );
    }

    private function initOperators(): void
    {
        try {
            $this->operators = $this->opeRepos->getOperatorsOptions();
            $operator = collect($this->operators)->filter(
                fn($ope) => str_contains($this->form->transporter, $ope['name']))->first();

            $this->operatorId = $operator['id'];
            // $this->assignOperator();
            $this->assignCrews();
            $this->assignVehicles(
                Constants::EMPTY_STRING, $this->operatorId
            );
        } catch (\Exception $e) {
            $this->addError('error', $e->getMessage());
        }
    }
    private function assignOperator(): void
    {
        try {
            $operator = collect($this->operators)->filter(
                fn($ope) => $ope['id'] == $this->operatorId)->first();

            $this->form->transporter = $operator['name']; //trim($operator['prefix'] . ' ' . $operator['name'] . ' ' . $operator['postfix']);
        } catch (\Exception $e) {
            $this->addError('error', $e->getMessage());
        }
    }
    private function assignCrews(): void
    {
        if (is_null($this->operatorId)) {
            $this->crews = $this->crewRepos->getCrewsOptions(
                $this->authUsr['operator_id']
            );
            return;
        }
        $collection = $this->wtMapper->mapToOptions(
            $this->crewRepos->getCrews($this->operatorId)
        );
        $this->crews = $collection->toArray();
    }
    private function assignVehicles(string $query, ?string $operatorId = null): void
    {
        $operatorId = is_null($operatorId) ? $this->authUsr['operator_id'] : $operatorId;
        $collection = $this->vehRepos
            ->getVehiclesByOperatorIdQuery($operatorId, $query, 5);

        $this->vehicles = $this->wtMapper->mapToOptions($collection)->toArray();
    }

    private function initWells(): void
    {
        $this->well = Constants::EMPTY_STRING;
        $this->searchWellBy($this->well);
    }

    private function initDateOptions(): void
    {
        $this->currentDate = empty($createdAt = $this->form->created_at)
            ? date('Y-m-d') : $createdAt;
    }

    private function initTimeOptions(): void
    {
        $this->timeOptions = $this->util
            ->getListOfTimesOptions(0, 22);

        $formTimeSession = session('form_time');
        $option = $formTimeSession
            ?? $this->timeOptions[0]['value'] ?? $this->form->time_in;

        $this->adjustTime($option);
    }

    private function initLocOptions(): void
    {
        $areaName = $this->authUsr['area_name'] ?? null;
        if (is_null($areaName)) return;

        $this->form->area_name = $areaName;
    }

    private function initDetail(): void
    {
        // $this->form->setWorkTripInDetailModel(new WorkTripDetailIn(array()));
        $this->assignPost();
    }

    private function adjustTime($time): void
    {
        $this->form->time_in = $time;
        $this->form->time_out = date($time, strtotime('+1 hour'));
    }

    public function onWellSelected(array $well): void
    {
        $this->form->well_name = $well['ids_wellname'];
        $this->form->rig_name = $well['rig_no'];
        $this->form->wbs_number = $well['wbs_number'];
    }
    public function onVehicleSelected(array $vehicle): void
    {
        $this->form->police_number = $vehicle['plat'];
    }

    public function onTimeOptionChange(): void
    {
        $this->adjustTime($this->form->time_in);
    }

    public function onOperatorOptionChange(): void
    {
        $this->assignOperator();
        $this->assignCrews();
        $this->assignVehicles(Constants::EMPTY_STRING);
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

    public function searchVehicleBy(?string $query = null): void
    {
        $this->assignVehicles($query, $this->operatorId);
    }

    public function save(): void
    {
        try {
            $this->form->update();

            $this->redirectRoute('work-trip-in-details.index', navigate: true);
        } catch (\Exception $e) {

            $this->addError('error', $e->getMessage());
        }
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip-in-detail.edit');
    }
}
