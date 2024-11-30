<?php

namespace App\Livewire\WorkTrips;

use App\Livewire\Forms\PostForm;
use App\Livewire\Forms\WorkTripForm;
use App\Models\Post;
use App\Models\UserCurrentPost;
use App\Models\WorkTrip;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\ActNameEnum;
use App\Utils\ActUnitEnum;
use App\Utils\Contracts\IUtility;
use App\Utils\PostTypeEnum;
use App\Utils\WorkTripScheduleEnum;
use App\Utils\WorkTripTypeEnum;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    protected IWorkTripRepository $workTripRepos;
    protected IDBRepository $dBRepos;
    protected IUserRepository $userRepos;
    protected IPostRepository $postRepos;
    protected IUtility $util;

    public WorkTripForm $form;
    public PostForm $postForm;
    public Collection $workTripsState;
    public array $timesState;
    public array $workTripsDeletedIds;

    public array $processes;
    public array $locations;
    public array $periods;

    public string $schedule;
    public bool $isEditMode = false;

    public function mount(WorkTrip $workTrip,
        IWorkTripRepository $workTripRepos,
        IDBRepository $dBRepos, IUtility $util,
        IUserRepository $userRepos,
        IPostRepository $postRepos): void
    {
        $this->userRepos = $userRepos;
        $this->postRepos = $postRepos;
        $this->workTripRepos = $workTripRepos;
        $this->dBRepos = $dBRepos;
        $this->util = $util;

        $workTrip->post_id = 'NA';
        $workTrip->act_name = ActNameEnum::Incoming->value;
        $this->form->setWorkTripModel($workTrip);
        $this->postForm->setPostModel(new Post());

        $this->onWorkTripInit();
    }

    public function booted(
        IWorkTripRepository $workTripRepos,
        IDBRepository $dBRepos, IUtility $util,
        IUserRepository $userRepos,
        IPostRepository $postRepos): void
    {
        $this->userRepos = $userRepos;
        $this->postRepos = $postRepos;
        $this->workTripRepos = $workTripRepos;
        $this->dBRepos = $dBRepos;
        $this->util = $util;

        $this->onActivityInit();
        $this->onScheduleInit();
        $this->onWorkTripInit();
    }

    private function onWorkTripInit(): void
    {
        $this->workTripsState = collect();

        $user = $this->userRepos->authenticatedUser();
        $userCurPost = $user->currentPost;
        if (is_null($userCurPost)) return;

        $posted = $this->postRepos->getPostByIdRaw($userCurPost->post_id);
        if (empty($workTrips = $posted->workTrips)) return;

        $this->onWorkTripReState($workTrips); // $this->workTripsState = $this->mapWorkTripsState($workTrips)->values();
        $this->isEditMode = true;
    }

    private function onWorkTripReState(Collection $workTrips): void
    {
        $this->workTripsState = $this->mapWorkTripsState($workTrips)->values();
    }

    private function onActivityInit(): void
    {
        $this->processes = $this->workTripRepos->getProcessOptions(
            $this->form->act_name
        );
        $this->locations = $this->workTripRepos->getLocationsOptions(
            $this->form->area_name
        );
    }

    public function onActivityChange(): void
    {
        $this->form->reset('act_process');
        $this->onActivityInit();
        $this->adjustActivityUnit();

        $this->onWorkTripReState($this->workTripsState);
    }

    public function onStateActivityPressed(): void
    {
        $this->form->validate();

        $this->onStateTimeSelection();
        $this->onStateWorkTripSelection();
    }

    private function onStateTimeSelection(): void
    {
        $current = $this->form->time;
        if (in_array($current, $this->timesState)) return;

        $this->timesState[] = $current;
        sort($this->timesState);
    }

    private function onStateWorkTripSelection(): void
    {
        $workTrip = $this->form->toArray();

        foreach ($this->workTripsState as $i => $trip) {
            if ($workTrip['act_process'] == $trip['act_process'] &&
                $workTrip['time'] == $trip['time'] &&
                $workTrip['area_loc'] == $trip['area_loc']) {

                $this->workTripsState[$i]['act_value'] = $this->form->act_value;
                return;
            }
        }
        //$this->workTripsState[] = $workTrip;
        $this->workTripsState->push($workTrip);

        /*usort($this->workTripsState, fn ($a, $b) =>
            $a['time'] > $b['time']
        );*/
    }

    public function formReset(): void
    {
        $this->form->reset('act_value', 'act_name', 'act_process', 'area_loc');
    }

    public function onRemoveWorkTripAt($tripToForget): void
    {
        $filteredTrips = $this->workTripsState
            ->filter(function ($trip) use ($tripToForget) {
                return $trip->id !== $tripToForget['id'];
            });
        $this->workTripsState = $filteredTrips->values();
    }

    public function onStateItemToEdit($trip): void
    {
        Log::debug("onStateItemToEdit: ". json_encode($trip));
        $this->form->fill($trip);
    }

    private function mapWorkTripsState(Collection $workTrips): Collection
    {
        return $workTrips
            ->filter(fn ($trip) => $trip->type == WorkTripTypeEnum::ACTUAL->value)
            ->map(function (WorkTrip $trip) {
                $trip->act_value = $trip->act_value . '/' . ($trip->info->act_value ?? 0);
                return $trip;
            });
    }

    private function adjustActivityUnit(): void
    {
        $unit = $this->form->act_name != ActNameEnum::Production->value
            ? ActUnitEnum::LOAD->value : ActUnitEnum::M3->value;
        $this->form->act_unit = $unit;
    }

    private function onScheduleInit(): void
    {
        $current = Carbon::now();
        $this->periods = $this->util->getListOfTimesOptions(8, 20);
        usort($this->periods, fn ($a, $b) => $b > $a);

        $period = collect($this->periods)->map(fn($p) => $p['value'])->toArray();
        if($period[0]) $this->form->time = $period[0];

        $start = Carbon::parse(min($period));
        $end = Carbon::parse(max($period));

        $this->schedule = $current->between($start, $end)
            ? WorkTripScheduleEnum::IN->value
            : WorkTripScheduleEnum::OUT->value;
    }

    public function saveWorkTripWithPost(): void
    {
        try {
            $user = $this->userRepos->authenticatedUser();

            if (empty($this->workTripsState))
                throw new \Exception('Please add the table form');

            $this->dBRepos->async();

            if (!empty($this->workTripsDeletedIds))
                foreach ($this->workTripsDeletedIds as $id) {
                    $this->workTripRepos->delete($id);
                }
            $posted = Post::factory()->create([
                'type' => PostTypeEnum::POST_WELL_TYPE->value,
                'user_id' => $user->id
            ]);
            $this->createWorkTripPostOf(
                WorkTripTypeEnum::PLAN->value, $posted->id
            );
            $this->createWorkTripPostOf(
                WorkTripTypeEnum::ACTUAL->value, $posted->id
            );
            $this->dBRepos->await();
            session()->flash('message', 'Work trip successfully submitted.');

        } catch (\Throwable $throwable) {
            $message = $throwable->getMessage();
            $this->dBRepos->cancel();
            $this->addError('error', $message);

            Log::debug($message);
        }
    }

    private function createWorkTripPostOf(string $type, string $postId): void
    {
        $i = $type == WorkTripTypeEnum::ACTUAL->value ? 0 : 1;

        foreach ($this->workTripsState as $workTrip) {
            $actValue = explode('/', $workTrip['act_value'])[$i];

            $workTrip['post_id'] = $postId;
            $workTrip['type'] = $type;
            $workTrip['act_value'] = $actValue;

            WorkTrip::query()->create($workTrip);
        }
    }
    public function save(): void
    {
        $this->form->store();

        $this->redirectRoute('work-trips.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip.create');
    }
}
