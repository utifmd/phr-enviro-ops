<?php

namespace App\Livewire\Workorders\Request;

use App\Livewire\Forms\WorkTripForm;
use App\Models\Activity;
use App\Models\Area;
use App\Models\PlanTrip;
use App\Models\Post;
use App\Models\WorkOrder;
use App\Models\WorkTrip;
use App\Policies\WorkTripPolicy;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActNameEnum;
use App\Utils\ActUnitEnum;
use App\Utils\PlanTripTypeEnum;
use App\Utils\WorkTripTypeEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    protected IDBRepository $dbRepos;
    protected IWorkTripRepository $workTripRepos;
    public WorkTripForm $form;
    public Post $post;
    public ?Collection $planTrips = null;
    public ?Collection $processes = null;
    public ?Collection $locations = null;

    public function booted(IDBRepository $dbRepos, IWorkTripRepository $workTripRepos): void
    {
        $this->dbRepos = $dbRepos;
        $this->workTripRepos = $workTripRepos;
        $this->onActivityChange();
    }

    public function mount(Post $post): void
    {
        Gate::authorize(WorkTripPolicy::IS_WORK_TRIP_CREATED, $post);

        $this->form->setWorkTripModel($post->workTrip);
        $this->post = $post;
        $this->planTrips = $post->planTrips->filter(fn (PlanTrip $trip) =>
            ($trip->trip_type != PlanTripTypeEnum::BTB->value ||
                $trip->trip_type != PlanTripTypeEnum::EMPTY->value) ||
            $trip->status == WorkTripTypeEnum::PLAN->value
        );
    }

    public function onActivityChange(): void
    {
        $this->processes = $this->workTripRepos->getProcessOptions($this->form->act_name);
        $this->locations = $this->workTripRepos->getLocationsOptions($this->form->area_name);

        $this->form->act_unit = $this->form->act_name != ActNameEnum::Production->value
            ? ActUnitEnum::LOAD->value : ActUnitEnum::M3->value;
    }

    public function onSubmit(): void
    {
        try {
            $this->dbRepos->async();
            $builder = PlanTrip::query()
                ->where('post_id', '=', $this->post->id)
                ->where('status', '=', WorkTripTypeEnum::PLAN->value);

            if ($this->form->act_name != ActNameEnum::Production->value) {
                $builder->limit($this->form->act_value)
                    ->update(['status' => WorkTripTypeEnum::ACTUAL->value]);
            }
            $attributes = $this->form->all();

            /*Log::debug("SEPARATOR");
            Log::debug(json_encode($attributes));*/
            //WorkTrip::query()->create($attributes);

            $this->form->store();
            $this->dbRepos->await();

        } catch (\Throwable $exception) {
            $this->dbRepos->cancel();

            Log::error($exception->getMessage());
        }
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.'.WorkOrder::ROUTE_NAME.'.request.create');
    }
}

