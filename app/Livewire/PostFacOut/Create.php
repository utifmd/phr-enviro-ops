<?php

namespace App\Livewire\PostFacOut;

use App\Livewire\Forms\WorkTripOutDetailForm;
use App\Mapper\Contracts\IWorkTripMapper;
use App\Models\PostFac;
use App\Models\PostFacIn;
use App\Models\PostFacOut;
use App\Repositories\Contracts\ICrewRepository;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\ILogRepository;
use App\Repositories\Contracts\IOperatorRepository;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IVehicleRepository;
use App\Repositories\Contracts\IWellMasterRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActNameEnum;
use App\Utils\Constants;
use App\Utils\Contracts\IUtility;
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

    public WorkTripOutDetailForm $form;

    public array $timeOptions, $authUsr, $wells,
        $operators, $vehicles, $crews, $facilities, $pits;

    public string $currentDate, $well;
    public ?string $operatorId = null;
    public bool $isEditMode = false, $areInfosExists = false;

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

    public function mount(PostFacOut $tripDetail): void
    {
        $this->form->setWorkTripOutDetailModel($tripDetail);

        $this->initAuthUser();
        $this->initDateOptions();

        $this->checkFacPlan();
        if (!$this->areInfosExists) {

            $this->addError('error', "Today's plan has not been set.");
            return;
        }
        $this->initAreas();
        $this->initWells();
        $this->initOperators();
        $this->initTimeOptions();
        $this->initLocOptions();
        $this->initDetail();
    }

    public function hydrate(): void
    {
        $this->initAuthUser();
        $this->initDateOptions();
        $this->assignOperator();
        $this->onTimeOptionChange();
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
        for ($i = 0; $i < 5; $i++) {
            $name = $i + 1;
            $this->pits[$i]['name'] = $name;
            $this->pits[$i]['value'] = $name;
        }
    }

    private function initOperators(): void
    {
        $this->operatorId = $this->authUsr['company_id'];
        $this->operators = $this->opeRepos->getOperatorsOptions();

        $this->assignOperator();
        $this->assignCrews();
        $this->assignVehicles(
            Constants::EMPTY_STRING, $this->operatorId
        );
    }
    private function checkFacPlan(): void
    {
        $this->areInfosExists = $this->wtRepos->areInfosExistByDateAndArea(
            $this->currentDate, $this->authUsr['area_name']
        );
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
                $this->authUsr['company_id']
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
        $operatorId = is_null($operatorId) ? $this->authUsr['company_id'] : $operatorId;
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
        $this->currentDate = date('Y-m-d');
        $this->form->created_at = $this->currentDate;
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
        $this->form->setWorkTripOutDetailModel(new PostFacOut(array()));
        $this->getCurrentPost();
    }

    private function adjustTime($time): void
    {
        $this->form->time_in = $time;
        $this->form->time_out = date($time, strtotime('+1 hour'));
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
        $this->assignVehicles(
            Constants::EMPTY_STRING, $this->operatorId
        );
    }

    private function getCurrentPost(): void
    {
        $post = $this->pstRepos
            ->postByDateBuilder($this->currentDate)
            ->whereHas('user', fn ($query) =>
            $query->where('area_name', $this->authUsr['area_name'])
            ); //$postId = $post->first()->id ?? $this->pstRepos->generatePost($this->authUsr);

        $this->form->post_id = $post->first()->id;
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

    /**
     * @throws ValidationException
     */
    public function save(): void
    {
        try {
            $validated = $this->form->validate();
            $this->dbRepos->async();

            $validated['type'] = ActNameEnum::Outgoing->value;
            $createdDetail = PostFac::query()->create($validated);
            PostFacOut::query()->create([
                'from_facility' => $this->form->from_facility,
                'from_pit' => $this->form->from_pit,
                'to_facility' => $this->form->to_facility,
                'type' => $this->form->type,
                'work_trip_detail_id' => $createdDetail->id,
            ]);
            $this->dbRepos->await();
            $this->redirectRoute('post-fac-out.index', navigate: true);

        } catch (\Exception $e) {
            $this->dbRepos->cancel();

            $this->addError('error', $e->getMessage());
        }
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.post-fac-out.create');
    }
}
