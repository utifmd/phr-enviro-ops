<?php

namespace App\Livewire\WorkTripInfos;

use App\Livewire\Forms\WorkTripInfoForm;
use App\Models\Activity;
use App\Models\Area;
use App\Models\WorkTripInfo;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActNameEnum;
use App\Utils\Contracts\IUtility;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
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
    protected IWorkTripRepository $wtRepos;

    public WorkTripInfoForm $form;
    public array
        $authUsr, $infoState, $locations,
        $dateOptions, $timeOptions, $delInfoQueue = [];
    public string $focusedDate;
    public bool $isEditMode = false;

    public function mount(
        WorkTripInfo $workTripInfo,
        IDBRepository $dbRepos,
        IUtility $util,
        IUserRepository $usrRepos,
        IWorkTripRepository $wtRepos): void
    {
        $date = $this->dateParam;
        $this->isEditMode = !is_null($date);

        $this->dbRepos = $dbRepos;
        $this->util = $util;
        $this->usrRepos = $usrRepos;
        $this->wtRepos = $wtRepos;

        $this->form->setWorkTripInfoModel($workTripInfo);
        $this->initAuthUser();
        $this->initDateOptions($date);
        $this->initTimeOptions($date);
        $this->initLocOptions();
        $this->checkInfoState($date);
    }

    public function hydrate(
        IDBRepository $dbRepos, IWorkTripRepository $wtRepos): void
    {
        $this->dbRepos = $dbRepos;
        $this->wtRepos = $wtRepos;
    }

    private function checkInfoState($dateParam): void
    {
        $this->isEditMode = !is_null($dateParam);
        if ($this->isEditMode) {
            $this->getInfoState($dateParam);
            return;
        }
        if ($this->wtRepos->areInfosExistBy($date = $this->focusedDate)) {
            $this->isEditMode = $date;
            $this->form->date = $date;
            $this->getInfoState($date);
            return;
        }
        $this->initInfoState();
    }

    private function initDateOptions(?string $date = null): void
    {
        $this->focusedDate = date('Y-m-d');

        if (!is_null($date)) {
            $this->dateOptions[] = ['name' => $date, 'value', $date];
            return;
        }
        $this->dateOptions = $this->util->getListOfDatesOptions(2);
        $this->form->date = $this->dateOptions[0]['value'] ?? '';
    }

    private function initTimeOptions(?string $date = null): void
    {
        if (!is_null($date)) {
            $this->timeOptions = $this->util->getListOfTimesOptions(
                8, 20, true
            );
            return;
        }
        $this->timeOptions = $this->util->getListOfTimesOptions(
            8, 20, true
        );
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
        $this->locations = $this->wtRepos->getLocations($areaName);
        // $this->form->area_loc = $this->locationOptions[0]['value'] ?? 'NA';
    }

    private function initInfoState(): void
    {
        if (!$this->isEditMode) {
            $this->infoState = array();
            $this->form->act_value = 0;
        }
        $this->form->user_id = $this->authUsr['id'];
        $acts = Activity::all();

        $this->populateByCMTF($acts);
        $this->populateByGS($acts);
    }

    private function getInfoState(string $date): void
    {
        $this->infoState = $this->wtRepos->getInfoByDate($date);
    }

    private function populateByGS(Collection $acts): void
    {
        foreach ($this->locations as $location) {
            if (ActNameEnum::Outgoing->value != $location['actName']) continue;

            $this->form->act_name = $location['actName'];
            $this->form->area_loc = $location['location'];

            foreach ($acts as $act) {
                if (ActNameEnum::Outgoing->value != $act->name) continue;

                $this->form->act_process = $act->process;
                $this->form->act_unit = $act->unit;
                $this->infoState[] = $this->form->toArray();
            }
        }
    }

    private function populateByCMTF(Collection $acts): void
    {
        foreach ($acts as $act) {
            if (ActNameEnum::Outgoing->value == $act->name) continue;

            $this->form->act_name = $act->name;
            $this->form->act_process = $act->process;
            $this->form->act_unit = $act->unit; // $this->form->area_loc = str_contains($area->location, 'CMTF');

            $areaLoc = null;
            foreach ($this->locations as $location) {
                if ($act->name == $location['actName']){
                    $areaLoc = $location['location'];
                }
            }
            if ($areaLoc) $this->form->area_loc = $areaLoc;

            $this->infoState[] = $this->form->toArray();
        }
    }

    private function mapInfoState(array $infoState, $time): array
    {
        $infoState = array_map(
            function ($info) use($time): array {
                $info['date'] = $this->form->date;
                $info['time'] = $time ?? $this->form->time;

                unset($info['workTripInfoModel']);
                return $info;
            },
            array_values($infoState)
        );
        return array_filter(
            $infoState, fn ($info) => !str_contains($info['time'], '-')
        );
    }

    /**
     * @throws ValidationException
     */
    public function onInfoStateValueSelected($idx): void
    {
        $this->form->validate(['act_value' => 'required|integer']);
        $this->infoState[$idx]['act_value'] = $this->form->act_value;
    }

    /**
     * @throws ValidationException
     */
    public function onInfoStateTimeSelected($idx): void
    {
        $this->form->validate(['time' => 'required|string']);
        $this->infoState[$idx]['time'] = $this->form->time;
    }

    public function onInfoStateActNameSelected($idx): void
    {
        try {
            $this->delInfoQueue[] = $this->infoState[$idx]['id'];
            unset($this->infoState[$idx]);
        } catch (\Exception $e) {
            $this->addError('error', $e->getMessage());
        }
    }

    /**
     * @throws ValidationException
     */
    public function onStateInfoPressed(): void
    {
        $this->form->validate();
        $this->initInfoState();
    }

    /**
     * @throws ValidationException
     */
    public function onDateOptionChange(): void
    {
        $this->form->validate(['date' => 'required|string']);
        $this->focusedDate = $this->form->date;
        $this->checkInfoState(null);
    }

    /*public function onTimeOptionChange(): void
    {
        Log::debug('selected time: '. $this->form->time);
    }*/

    private function savePopulated($time): void
    {
        if (!empty($this->delInfoQueue)) foreach ($this->delInfoQueue as $infoId) {
            $this->wtRepos->removeInfoById($infoId);
        }
        if ($this->isEditMode) {
            foreach ($this->infoState as $info) {
                $this->wtRepos->updateInfo($info);
            }
            return;
        }
        $infoState = $this->mapInfoState($this->infoState, $time);
        foreach ($infoState as $info) {
            $this->wtRepos->addInfo($info);
        }
    }

    public function save(): void
    {
        try {
            $this->dbRepos->async();
            if (str_contains($this->form->time, '-')) {
                $times = array_map(fn($opt) => $opt['value'], array_values($this->timeOptions));
                foreach ($times as $time) { $this->savePopulated($time); }
            } else {
                $this->savePopulated(null);
            }
            $this->dbRepos->await();

            $this->redirectRoute('work-trip-infos.index', navigate: true);
        } catch (\Throwable $t) {
            $this->dbRepos->cancel();

            $this->addError('error', $t->getMessage());
        }
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip-info.create');
    }
}
