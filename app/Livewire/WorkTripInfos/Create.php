<?php

namespace App\Livewire\WorkTripInfos;

use App\Livewire\BaseComponent;
use App\Livewire\Forms\WorkTripInfoForm;
use App\Models\Activity;
use App\Models\WorkTripInfo;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActNameEnum;
use App\Utils\Contracts\IUtility;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

class Create extends BaseComponent
{
    #[Url]
    public ?string $dateParam = null;

    protected IDBRepository $dbRepos;
    protected IUtility $util;
    protected IUserRepository $usrRepos;
    protected IPostRepository $pstRepos;
    protected IWorkTripRepository $wtRepos;

    public WorkTripInfoForm $form;
    public array
        $authUsr, $infoState, $locations,
        $dateOptions, $timeOptions, $delInfoQueue = [];
    public ?string $postId, $focusedDate;
    public bool $isEditMode = false;

    public function mount(
        WorkTripInfo $workTripInfo,
        IDBRepository $dbRepos,
        IUtility $util,
        IUserRepository $usrRepos,
        IPostRepository $pstRepos,
        IWorkTripRepository $wtRepos): void
    {
        $date = $this->dateParam;
        $this->isEditMode = !is_null($date);

        $this->dbRepos = $dbRepos;
        $this->util = $util;
        $this->usrRepos = $usrRepos;
        $this->pstRepos = $pstRepos;
        $this->wtRepos = $wtRepos;

        $this->form->setWorkTripInfoModel($workTripInfo);
        $this->initAuthUser();
        $this->initDateOptions($date);
        $this->initTimeOptions(/*$date*/);
        $this->initLocOptions();
        $this->checkInfoState($date);
    }

    public function hydrate(
        IDBRepository $dbRepos, IPostRepository $pstRepos, IWorkTripRepository $wtRepos): void
    {
        $this->dbRepos = $dbRepos;
        $this->pstRepos = $pstRepos;
        $this->wtRepos = $wtRepos;
    }

    private function checkInfoState($dateParam): void
    {
        $this->isEditMode = !is_null($dateParam);
        if ($this->isEditMode) {
            $this->getInfoState($dateParam);
            return;
        }
        $date = $this->focusedDate;
        $areaName = $this->authUsr['area_name'];
        $areInfosExists = str_contains($this->form->time, '-')
            ? $this->wtRepos->areInfosExistByDateAndArea($date, $areaName)
            : $this->wtRepos->areInfosExistByDatetimeAndArea($date, $this->form->time, $areaName);

        if ($areInfosExists) {
            $this->isEditMode = true;
            $this->getInfoState($date);
            return;
        }
        $this->initInfoState();
    }

    private function checkPost(): void
    {
        $arePostExistByAndArea = $this->pstRepos->arePostExistByAndArea(
            $this->focusedDate, $this->authUsr['area_name']
        );
        if ($arePostExistByAndArea){
            $this->postId = null;
            return;
        }
        $this->postId = $this->pstRepos->generatePost(
            $this->authUsr, ['created_at' => $this->focusedDate]
        );
    }

    /**
     * @throws \Exception
     */
    private function checkInfoDeletion(): void
    {
        if (empty($this->delInfoQueue)) return;
        $info = $this->delInfoQueue[0];

        $areTripsAlreadyExist = $this->wtRepos->areTripsExistByDatetimeAndArea(
            $info['date'], $info['time'], $info['area_name']
        );
        if ($areTripsAlreadyExist) {
            throw new \Exception('Failed, the plan already used by contractor.');
        }
        foreach ($this->delInfoQueue as $info) {
            $this->wtRepos->removeInfoById($info['id']);
        }
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

    private function initTimeOptions(/*?string $date = null*/): void
    {
        /*if (!is_null($date)) {
            $this->timeOptions = $this->util->getListOfTimesOptions(
                8, 20, true
            );
            return;
        }*/
        /*$areRoleBeginAt7 = $this->authUsr['area_name'] == AreaNameEnum::HO->value;
        $this->timeOptions = $this->util->getListOfTimesOptions(
            $areRoleBeginAt7 ? 7 : 8,
            $areRoleBeginAt7 ? 19 : 20, true
        );*/
        $this->timeOptions = $this->util->getListOfTimesOptions(
            0, 22, true
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
            $this->form->act_value = empty($this->form->act_value)
                ? 0 : $this->form->act_value;
        }
        $this->form->user_id = $this->authUsr['id'];
        $acts = Activity::all();

        $this->populateByCMTF($acts);
        $this->populateByGS($acts);
    }

    private function getInfoState(string $date): void
    {
        $areaName = $this->authUsr['area_name'];
        $this->form->date = $date;
        $this->form->act_value = 20;
        if (str_contains($this->form->time, '-')) {
            $this->infoState = $this->wtRepos->getInfoByDateAndArea($date, $areaName);
            return;
        }
        $this->infoState = $this->wtRepos->getInfoByDatetimeAndArea(
            $date, $this->form->time, $areaName
        );
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
                $info['post_id'] = $this->postId;
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
            if ($this->isEditMode && $info = $this->infoState[$idx]) {
                $this->delInfoQueue[] = $info;
            }
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
        $this->scrollToBottom();
    }

    /**
     * @throws ValidationException
     */
    public function onDateOptionChange(): void
    {
        $this->form->validate(['date' => 'required|string']);
        $this->focusedDate = $this->form->date;
        $this->checkInfoState(null);
        $this->scrollToBottom();
    }

    /**
     * @throws ValidationException
     */
    public function onTimeOptionChange(): void
    {
        if ($this->isEditMode) {
            $this->form->validate(['date' => 'required|string']);
        }
        $this->checkInfoState(null);
        $this->scrollToBottom();
    }

    private function savePopulated($time): void
    {
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
            $this->checkPost();
            $this->checkInfoDeletion();
            if (str_contains($this->form->time, '-')) {
                $times = array_map(fn($opt) => $opt['value'], array_values($this->timeOptions));
                foreach ($times as $time) { $this->savePopulated($time); }
            } else {
                $this->savePopulated(null);
            }
            $this->dbRepos->await();

            session()->flash(
                'message', 'Your change successfully saved.'
            );
            $this->isEditMode = true;
            $this->scrollToTop();
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
