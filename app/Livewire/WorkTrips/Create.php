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
    public array $authUsr, $tripState, $timeOptions;
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
        $this->initTimeOptions();
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
        $this->isEditMode = false;
        if ($this->wtRepos->areTripsExistByDatetime($date = $this->currentDate, $this->form->time)) {
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

    private function initTimeOptions(): void
    {
        $this->timeOptions = $this->util->getListOfTimesOptions(0, 22);
        $this->form->time = $this->timeOptions[0]['value'] ?? '';
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
            $infoState = $this->wtRepos->getInfoByDatetime($this->currentDate, $this->form->time);
            $this->tripState = $this->mapInfoToPlanTripState($infoState);

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    private function getTripState(string $date): void
    {
        $tripState = $this->wtRepos->getTripByDatetime($date, $this->form->time);
        $this->tripState = $this->wtRepos->mapTripPairActualValue($tripState);
    }

    private function assignPost(array $tripState): void
    {
        $operator = $this->authUsr['operator'];
        $actValSum = $this->wtRepos
            ->sumActualByAreaAndDate($this->authUsr['area_name'], $this->form->date);
        $patch = [
            'id' => $tripState[0]['post_id'],
            'title' => trim($operator['prefix'] .' '. $operator['name'] .' '. $operator['postfix']),
            'description' => 'Total Actual at '.$this->form->date.' is '.$actValSum. ' Load',
        ];
        $this->pstRepos->updatePost($patch);
    }

    private function mapInfoToPlanTripState(array $infos): array
    {
        $trips = [];
        foreach ($infos as $trip) {
            $trip['type'] = WorkTripTypeEnum::PLAN->value;
            $trip['status'] = WorkTripStatusEnum::APPROVED->value;
            $trip['act_value'] = $this->form->act_value .'/'. $trip['act_value'];
            $trips[] = $trip;
        } // usort($trips, fn ($a, $b) => $b['act_process'] < $a['act_process']);
        return $trips;
    }

    private function mapTripState(array $tripState): array
    {
        $trips = [];
        foreach ($tripState as $trip) {
            $actPlanVal = explode('/', $trip['act_value']);

            $trip['type'] = WorkTripTypeEnum::ACTUAL->value;
            $trip['status'] = WorkTripStatusEnum::PENDING->value;
            $trip['act_value'] = $actPlanVal[0];
            $trip['user_id'] = $this->authUsr['id'];
            $trips[] = $trip;
        }
        foreach ($tripState as $i => $trip) {
            if ($trip['type'] != WorkTripTypeEnum::PLAN->value) continue;

            $actPlanVal = explode('/', $trip['act_value']);
            $tripState[$i]['act_value'] = $actPlanVal[1];
        }
        return array_merge($trips, $tripState);
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
        $this->checkTripState();
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

    public function onTimeOptionChange(): void
    {
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
            $tripState = $this->wtRepos->mapTripUnpairActualValue($this->tripState);
            foreach ($tripState as $trip){ $this->wtRepos->updateTrip($trip); }
        } else {

            $tripState = $this->mapTripState($this->tripState);
            foreach ($tripState as $trip){ $this->wtRepos->addTrip($trip); }
        }
        $this->assignPost($tripState);
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
