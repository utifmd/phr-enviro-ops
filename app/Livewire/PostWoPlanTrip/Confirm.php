<?php

namespace App\Livewire\PostWoPlanTrip;

use App\Livewire\Actions\GetStep;
use App\Livewire\Actions\UpdateUserCurrentPost;
use App\Models\PostWoPlanOrder;
use App\Models\PostWoPlanTrip;
use App\Models\PostWo;
use App\Models\PostFacReport;
use App\Utils\PostWoPlanTripTypeEnum;
use App\Utils\PostFacReportTypeEnum;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Confirm extends Component
{
    private string $userId;
    public string $postId;
    public array $steps;
    public int $stepAt;
    public bool $disabled;
    public array $planTrips = [];
    public array $planTrip = [];
    public int $tripTimes;

    public function __construct()
    {
        $currentUser = auth()->user();

        $this->userId = $currentUser->getAuthIdentifier();
        if ($currentPost = $currentUser->currentPost ?? false){

            $this->postId = $currentPost->post_id;
        }
        $getStep = new GetStep($currentUser);

        $this->steps = $getStep->getSteps();
        $this->stepAt = $getStep->getStepAt();
        $this->disabled = in_array(PostWoPlanTrip::ROUTE_POS, $this->steps) &&
            $this->stepAt != PostWoPlanTrip::ROUTE_POS;
    }

    public function mount(): void
    {
        $tripOrders = $this->getTripOrders($this->postId);
        if($tripOrders->isEmpty()) return;

        $tripOrder = $tripOrders->first();
        $tripPlan = [
            'yard' => $tripOrder->yard,
            'pick_up_from' => $tripOrder->pick_up_from,
            'destination' => $tripOrder->destination
        ];
        $this->setTripTimes($tripOrder->trip);
        $this->setTripPlans($this->tripTimes, $tripPlan);
        $this->planTrip = $tripPlan;
    }

    public function onTripTimeKeyDownEnter(): void
    {
        $this->setTripPlans($this->tripTimes, $this->planTrip);
    }

    private function getTripOrders(string $postId): Collection
    {
        return PostWoPlanOrder::query()
            ->select('yard', 'pick_up_from', 'destination', 'trip')
            ->where('post_id', '=', $postId)
            ->get();
    }

    private function setTripPlans(int $times, array $planTrip): void
    {
        if (count($this->planTrips) > 0) {
            $this->planTrips = [];
        }
        for ($i = 0; $i < $times; $i++) {
            $batch = [];
            $batch['no'] = $i + 1;
            switch ($i) {
                case 0:
                    $batch['trip_type'] = PostWoPlanTripTypeEnum::EMPTY;
                    $batch['start_from'] = $planTrip['yard'];
                    $batch['finish_to'] = $planTrip['pick_up_from'];
                    break;

                case ($this->tripTimes -1):
                    $batch['trip_type'] = PostWoPlanTripTypeEnum::BTB;
                    $batch['start_from'] = $planTrip['destination'];
                    $batch['finish_to'] = $planTrip['yard'];
                    break;

                default:
                    $batch['trip_type'] = PostWoPlanTripTypeEnum::LOADED;
                    $batch['start_from'] = $planTrip['pick_up_from'];
                    $batch['finish_to'] = $planTrip['destination'];
                    break;
            }
            $this->planTrips[$i] = $batch;
        }
    }

    public function setTripTimes(int $tripTimes): void
    {
        $this->tripTimes = $tripTimes;
    }
    public function confirmThenNextToWorkOrder(): void
    {
        try {
            DB::beginTransaction();
            $updateUserCurrentPost = new UpdateUserCurrentPost();

            foreach ($this->planTrips as $tripPlan) {
                /*$model = new PlanTrip();
                $model->start_from = $tripPlan['start_from'];
                $model->finish_to = $tripPlan['finish_to'];
                $model->trip_type = $tripPlan['trip_type'];
                $model->post_id = $this->postId;
                $model->save();*/
                $tripPlan['post_id'] = $this->postId;
                PostWoPlanTrip::query()->create($tripPlan);
            }

            /*$workTrip = [
                'act_name' => $acts[$actIdx]['name'],
                'act_process' => $acts[$actIdx]['process'],
                'act_unit' => $acts[$actIdx]['unit'],
                'area_name' => $areas[$areaIdx]['name'],
                'area_loc' => $areas[$areaIdx]['location'],
                'post_id' => $postIds[rand(0, count($postIds) - 1)],
            ];
            WorkTrip::factory(count($this->tripPlans))->create($workTrip);*/

            PostWoPlanOrder::query()
                ->where('post_id', '=', $this->postId)
                ->update(['trip' => $this->tripTimes]);

            $userCurrentPost = [
                'steps' => '0;1;2;3;4',
                'step_at' => 4,
                'url' => PostWo::ROUTE_NAME.'.blueprint'
            ];
            $updateUserCurrentPost($this->userId, $userCurrentPost);
            DB::commit();

            $this->redirectRoute(
                $userCurrentPost['url'], parameters: $this->postId, navigate: true
            );
        } catch (\Exception $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());
            session()->flash(
                'message', $exception->getMessage()
            );
        }
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.'.PostWoPlanTrip::ROUTE_NAME.'.create');
    }
}
