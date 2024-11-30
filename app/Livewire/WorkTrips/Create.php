<?php

namespace App\Livewire\WorkTrips;

use App\Livewire\Forms\WorkTripForm;
use App\Models\Activity;
use App\Models\WorkTrip;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActNameEnum;
use App\Utils\ActUnitEnum;
use App\Utils\AreaNameEnum;
use App\Utils\Contracts\IUtility;
use App\Utils\WorkTripStatusEnum;
use App\Utils\WorkTripTypeEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class Create extends Component
{
    #[Url]
    public ?string $dateParam = null;

    protected IDBRepository $dbRepos;
    protected IUtility $util;
    protected IUserRepository $usrRepos;
    protected IPostRepository $pstRepos;
    protected IWorkTripRepository $wtRepos;

    public WorkTripForm $form;
    public array $authUsr, $tripState;
    public string $currentDate;
    public bool $isEditMode = false;

    public function mount(
        WorkTrip $workTrip,
        IDBRepository $dbRepos,
        IUtility $util,
        IUserRepository $usrRepos,
        IPostRepository $pstRepos,
        IWorkTripRepository $wtRepos): void
    {
        $this->dbRepos = $dbRepos;
        $this->util = $util;
        $this->usrRepos = $usrRepos;
        $this->wtRepos = $wtRepos;
        $this->pstRepos = $pstRepos;

        $this->form->setWorkTripModel($workTrip);
        $this->initAuthUser();
        $this->initDateOptions();
        $this->initLocOptions();
        $this->checkTripState();
    }

    public function hydrate(
        IDBRepository $dbRepos,
        IPostRepository $pstRepos,
        IWorkTripRepository $wtRepos): void
    {
        $this->dbRepos = $dbRepos;
        $this->wtRepos = $wtRepos;
        $this->pstRepos = $pstRepos;
    }

    private function checkTripState(): void
    {
        if ($this->wtRepos->areTripsExistBy($date = $this->currentDate)) {
            $this->isEditMode = true;
            $this->form->date = $date;
            $this->getTripState($date);
            return;
        }
        $this->initTripState();
    }

    private function initDateOptions(): void
    {
        $this->currentDate = is_null($this->dateParam)
            ? date('Y-m-d') : $this->dateParam;
    }

    private function initAuthUser(): void
    {
        $this->authUsr = $this->usrRepos->authenticatedUser()->toArray();
    }

    private function initLocOptions(): void
    {
        $areaName = $this->authUsr['area_name'] ?? null;
        if (is_null($areaName)) return;

        $this->form->area_name = $areaName;
    }

    private function initTripState(): void
    {
        $this->form->act_value = empty($this->form->act_value)
            ? 0 : $this->form->act_value;
        try {
            $infoState = $this->wtRepos->getInfoByDate($this->currentDate);
            $this->tripState = $this->mapInfoToPlanTripState($infoState);

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    private function getTripState(string $date): void
    {
        $this->tripState = $this->wtRepos->getTripByDate($date);
    }

    private function mapInfoToPlanTripState(array $infos): array
    {
        $trips = [];
        $this->form->post_id = $infos[0]['post_id'];
        foreach ($infos as $trip) {
            $trip['type'] = WorkTripTypeEnum::PLAN->value;
            $trip['status'] = WorkTripStatusEnum::APPROVED->value;
            $trip['act_value'] = $this->form->act_value .'/'. $trip['act_value'];
            $trips[] = $trip;
        }
        return $trips;
    }

    private function assignPost(): void
    {
        $operator = $this->authUsr['operator'];
        $tripLoadState = array_filter($this->tripState, fn($trip) =>
            $trip['act_unit'] == ActUnitEnum::LOAD->value
        );
        $actValState = array_map(fn($trip) =>
            explode('/', $trip['act_value'])[0], $tripLoadState
        );
        $patch = [
            'id' => $this->form->post_id,
            'title' => trim($operator['prefix'] .' '. $operator['name'] .' '. $operator['postfix']),
            'description' => 'Total Actual at '.$this->form->date.' is '.array_sum($actValState). ' Load',
        ];
        $this->pstRepos->updatePost($patch);
    }

    private function mapTripState(array $planTripState): array
    {
        $trips = [];
        foreach ($planTripState as $trip) {
            $actPlanVal = explode('/', $trip['act_value']);

            $trip['type'] = WorkTripTypeEnum::ACTUAL->value;
            $trip['status'] = WorkTripStatusEnum::PENDING->value;
            $trip['act_value'] = $actPlanVal[0];
            $trip['user_id'] = $this->authUsr['id'];
            $trips[] = $trip;
        }
        foreach ($planTripState as $i => $trip) {
            if ($trip['type'] != WorkTripTypeEnum::PLAN->value) continue;

            $actPlanVal = explode('/', $trip['act_value']);
            $planTripState[$i]['act_value'] = $actPlanVal[1];
        }
        return array_merge($trips, $planTripState);
    }

    /**
     * @throws ValidationException
     */
    public function onTripStateValueSelected($idx): void
    {
        $this->form->validate(['act_value' => 'required|integer']);
        $this->tripState[$idx]['act_value'] = $this->form->act_value;
    }

    /**
     * @throws ValidationException
     */
    public function onTripStateTimeSelected($idx): void
    {
        $this->form->validate(['time' => 'required|string']);
        $this->tripState[$idx]['time'] = $this->form->time;
    }

    /**
     * @throws ValidationException
     */
    public function onStateTripPressed(): void
    {
        $this->form->validate();
        $this->initTripState();
    }

    /**
     * @throws ValidationException
     */
    public function onDateOptionChange(): void
    {
        $this->form->validate(['date' => 'required|string']);
        $this->currentDate = $this->form->date;
        $this->checkTripState();
    }

    /**
     * @throws ValidationException
     */
    public function onInfoStateValueSelected($idx): void
    {
        $this->form->validate(['act_value' => 'required|integer']);
        try {
            $actPlanVal = explode('/', $this->tripState[$idx]['act_value']);

            $this->tripState[$idx]['act_value'] = $this->form->act_value . '/' . $actPlanVal[1];
        } catch (\Exception $e) {
            $this->addError('error', $e->getMessage());
        }
    }

    private function savePopulated(): void
    {
        if ($this->isEditMode) {
            foreach ($this->tripState as $trip) {
                $this->wtRepos->updateTrip($trip);
            }
            return;
        }
        $actualTripState = $this->mapTripState($this->tripState);

        foreach ($actualTripState as $trip) {
            $this->wtRepos->addTrip($trip);
        }
    }

    /**
     * @throws ValidationException
     */
    public function onStateInfoPressed(): void
    {
        $this->form->validate(['act_value' => 'required|integer']);
        $this->initTripState();
    }

    public function save(): void
    {
        try {
            $this->dbRepos->async();
            $this->savePopulated();
            $this->assignPost();
            $this->redirectRoute('work-trips.index', navigate: true);

            $this->dbRepos->await();
        } catch (\Throwable $t) {

            $this->dbRepos->cancel();
            $this->addError('error', $t->getMessage());
        }
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip.create');
    }
}
