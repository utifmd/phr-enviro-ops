<?php

namespace App\Livewire\WorkTripInfos;

use App\Livewire\Forms\WorkTripInfoForm;
use App\Models\Activity;
use App\Models\Area;
use App\Models\WorkTripInfo;
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
    protected IUtility $util;
    protected IUserRepository $usrRepos;
    protected IWorkTripRepository $wtRepos;

    public WorkTripInfoForm $form;
    public array $authUsr, $infoState, $locations, $dateOptions, $timeOptions;

    #[Url] // isEditMode
    public ?string $dateParam = null;

    public function mount(
        WorkTripInfo $workTripInfo,
        IUtility $util,
        IUserRepository $usrRepos, IWorkTripRepository $wtRepos): void
    {
        $date = $this->dateParam;

        $this->util = $util;
        $this->usrRepos = $usrRepos;
        $this->wtRepos = $wtRepos;

        $this->form->setWorkTripInfoModel($workTripInfo);
        $this->initAuthUser();
        $this->initDateOptions($date);
        $this->initTimeOptions($date);
        $this->initLocOptions();

        if (!is_null($date)) {
            $this->getInfoState($date);
            return;
        }
        $this->initInfoState();
    } // public function hydrate(): void { $this->initAuthUser(); }

    private function initDateOptions(?string $date = null): void
    {
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
        if (is_null($this->dateParam))
            $this->infoState = array();

        $this->form->user_id = $this->authUsr['id'];
        $acts = Activity::all();

        $this->populateByCMTF($acts);
        $this->populateByGS($acts);
    }

    private function getInfoState(string $date): void
    {
        $this->infoState = WorkTripInfo::query()->where('date', $date)->get()->toArray();
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
        return array_map(
            function ($info) use($time): array {
                $info['date'] = $this->form->date;
                $info['time'] = $time ?? $this->form->time;
                unset($info['workTripInfoModel']);
                return $info;
            },
            array_values($infoState)
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
        unset($this->infoState[$idx]);
    }

    /**
     * @throws ValidationException
     */
    public function onStateInfoPressed(): void
    {
        $this->form->validate();
        $this->initInfoState();
    }

    /*public function onDateOptionChange(): void
    {
        Log::debug('selected date: '. $this->form->date);
    }

    public function onTimeOptionChange(): void
    {
        Log::debug('selected time: '. $this->form->time);
    }*/

    private function savePopulated($time): void
    {
        $infoState = $this->mapInfoState($this->infoState, $time);

        foreach ($infoState as $info) {
            WorkTripInfo::query()->create($info);
        }
    }

    public function save(): void
    {
        if (str_contains($this->form->time, '-')) {
            $times = array_map(fn($opt) => $opt['value'], array_values($this->timeOptions));

            foreach ($times as $time) {
                $this->savePopulated($time);
            }
            $this->redirectRoute('work-trip-infos.index', navigate: true);
            return;
        }
        $this->savePopulated(null);
        $this->redirectRoute('work-trip-infos.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip-info.create');
    }
}
