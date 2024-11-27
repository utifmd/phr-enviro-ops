<?php

namespace App\Livewire\PlanOrders;

use App\Livewire\Actions\GetStep;
use App\Livewire\Forms\PlanOrderForm;
use App\Livewire\Forms\WorkTripForm;
use App\Models\PlanOrder;
use App\Models\PlanTrip;
use App\Models\WellMaster;
use App\Models\WorkTrip;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\IUserCurrentPostRepository;
use App\Repositories\Contracts\IWellMasterRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActNameEnum;
use App\Utils\ActUnitEnum;
use App\Utils\WorkTripTypeEnum;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    protected IUserCurrentPostRepository $userCurrentPostRepos;
    protected IWellMasterRepository $wellRepos;
    protected IWorkTripRepository $workTripRepos;

    public PlanOrderForm $form;
    public WorkTripForm $workTripForm;
    public array $workTrips = [];
    private Authenticatable $user;

    protected WellMaster $wellMaster;
    public array $searchedWells;
    public array $processes;
    public array $locations;

    public string $postId;
    public array $steps;
    public int $stepAt;
    public bool $disabled;
    public bool $isEditMode = false;

    public array $statusSuggest = ['Booked', 'Done'];
    public array $uomSuggest = ['Loads'];
    public array $yardSuggest = ['Green Yard', 'WDR TRP Duri'];
    public array $descSuggest = ['VCT to SUCK DISPOSAL'];

    public function __construct()
    {
        $this->user = auth()->user();
        if ($currentPost = $this->user->currentPost ?? false){

            $this->postId = $currentPost->post_id;
        }
        $getStep = new GetStep($this->user);
        $this->steps = $getStep->getSteps();
        $this->stepAt = $getStep->getStepAt();
        $this->disabled = false; // in_array(PlanOrder::ROUTE_POS, $this->steps) && $this->stepAt != PlanOrder::ROUTE_POS;
    }

    public function mount(PlanOrder $order): void
    {
        $builder = PlanOrder::query()
            ->where('post_id', '=', $this->postId)
            ->get();
        $model = $order;

        if ($builder->isNotEmpty()) {
            $model = $builder->first();
            $this->isEditMode = true;
        }
        $model->post_id = $this->postId;
        $this->form->setPlanOrder($model);

        $workTrip = new WorkTrip();
        $workTrip->type = WorkTripTypeEnum::PLAN->value;
        $workTrip->post_id = $this->postId;
        $this->workTripForm->setWorkTripModel($workTrip);
    }

    public function booted(
        IWellMasterRepository $wellRepos,
        IUserCurrentPostRepository $userCurrentPostRepos,
        IWorkTripRepository $workTripRepos): void
    {
        $this->workTripRepos = $workTripRepos;

        $this->wellMaster = new WellMaster();
        $this->wellRepos = $wellRepos;
        $this->userCurrentPostRepos = $userCurrentPostRepos;

        $this->onPickUpFromInit();
        $this->onActivityInit();
        /*$this->workTrips = $this->workTripRepos
            ->getByPostId($this->postId);*/
    }

    public function onPickUpFromChange(): void
    {
        $this->onPickUpFromInit();

        $this->searchedWells = $this->wellRepos
            ->getWellMastersByQuery($this->form->pick_up_from)
            ->toArray();
    }
    public function onPickUpFromInit(): void
    {
        $this->searchedWells = $this->wellRepos
            ->getWellMasters(1)->toArray();
    }

    public function onAddActivityPressed(): void
    {
        $this->workTripForm->validate();
        $workTrip = $this->workTripForm->toArray();

        foreach ($this->workTrips as $i => $trip) {
            if ($workTrip['act_process'] != $trip['act_process']) continue;

            $this->workTrips[$i]['act_value'] = $this->workTripForm->act_value;
            $this->workTripForm->reset();
            return;
        }

        $this->workTrips[] = $workTrip;
        $this->workTripForm->reset();
    }

    public function onTableHeaderPressed(int $i): void
    {
        unset($this->workTrips[$i]);
    }

    public function onActValueChange(): void
    {
        $this->form->sch_qty = $this->workTripForm->act_value;
    }

    private function onActivityInit(): void
    {
        $this->processes = $this->workTripRepos->getProcessOptions(
            $this->workTripForm->act_name
        );
        $this->locations = $this->workTripRepos->getLocationsOptions(
            $this->workTripForm->area_name
        );
    }
    public function onActivityChange(): void
    {
        $this->onActivityInit();
        $unit = $this->workTripForm->act_name != ActNameEnum::Production->value
            ? ActUnitEnum::LOAD->value : ActUnitEnum::M3->value;
        $this->form->uom = $unit;
        $this->workTripForm->act_unit = $unit;
    }

    public function onDestChange(): void
    {
        $this->workTripForm->area_loc = $this->form->destination;
    }

    public function onPickUpFromSelect(string $encodedWell): void
    {
        $well = json_decode($encodedWell);

        $this->form->pick_up_from = $well->ids_wellname;
        $this->form->rig_name = $well->rig_no;
        $this->form->charge = $well->wbs_number;
    }

    public function addOrderThenNextToTripPlan(): void
    {
        $loadTypeWorkTrips = collect($this->workTrips)
            ->filter(fn($trip) => $trip['act_unit'] != 'm3');

        if ($loadTypeWorkTrips->isNotEmpty()) {
            $this->form->trip = $loadTypeWorkTrips->count();
        }
        $this->workTripForm->storeAll($this->workTrips);
        $this->form->store();
        $userCurrentPost = [
            'steps' => '0;1;2;3',
            'step_at' => PlanTrip::ROUTE_POS,
            'url' => PlanTrip::ROUTE_NAME . '.confirm'
        ];
        $this->userCurrentPostRepos->update(
            $this->user->getAuthIdentifier(), $userCurrentPost
        );
        session()->flash(
            'message', 'Show Orders successfully submitted, please follow the next step!'
        );
        $this->redirectRoute($userCurrentPost['url'], navigate: true);
    }

    public function changePlanOrder(): void
    {
        $this->form->update();

        session()->flash(
            'message', 'Show Orders successfully submitted, please follow the next step!'
        );
    }

    public function onStatusSelected(string $text): void
    {
        $this->form->setStatus($text);
        $this->statusSuggest = array_filter(
            $this->statusSuggest, function($item) use ($text) {
            return $item !== $text;
        });
    }

    public function onUomSelected(string $text): void
    {
        $this->form->setUom($text);
        $this->uomSuggest = array_filter(
            $this->uomSuggest, function($item) use ($text) {
            return $item !== $text;
        });
    }

    public function onYardSelected(string $text): void
    {
        $this->form->setYard($text);
        $this->yardSuggest = array_filter(
            $this->yardSuggest, function($item) use ($text) {
            return $item !== $text;
        });
    }

    public function save(): void
    {
        $this->form->store();

        $this->redirectRoute(PlanOrder::ROUTE_NAME.'.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $case = $this->isEditMode ? '.edit' : '.create';
        return view(
            'livewire.'.PlanOrder::ROUTE_NAME. $case
        );
    }
}
