<?php

namespace App\Livewire\PlanTrips;

use App\Livewire\Actions\GetStep;
use App\Livewire\Actions\UpdateUserCurrentPost;
use App\Models\PlanOrder;
use App\Models\PlanTrip;
use App\Models\WorkOrder;
use App\Utils\TripPlanTypeEnum;
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
    public array $tripPlans = [];
    public array $tripPlan = [];
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
        $this->disabled = in_array(PlanTrip::ROUTE_POS, $this->steps) &&
            $this->stepAt != PlanTrip::ROUTE_POS;
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
        $this->tripPlan = $tripPlan;
    }

    public function onTripTimeKeyDownEnter(): void
    {
        $this->setTripPlans($this->tripTimes, $this->tripPlan);
    }

    private function getTripOrders(string $postId): Collection
    {
        return PlanOrder::query()
            ->select('yard', 'pick_up_from', 'destination', 'trip')
            ->where('post_id', '=', $postId)
            ->get();
    }

    private function setTripPlans(int $times, array $tripPlan): void
    {
        if (count($this->tripPlans) > 0) {
            $this->tripPlans = [];
        }
        for ($i = 0; $i < $times; $i++) {
            $batch = [];
            $batch['no'] = $i + 1;
            switch ($i) {
                case 0:
                    $batch['trip_type'] = TripPlanTypeEnum::TRIP_PLAN_EMPTY;
                    $batch['start_from'] = $tripPlan['yard'];
                    $batch['finish_to'] = $tripPlan['pick_up_from'];
                    break;

                case ($this->tripTimes -1):
                    $batch['trip_type'] = TripPlanTypeEnum::TRIP_PLAN_BTB;
                    $batch['start_from'] = $tripPlan['destination'];
                    $batch['finish_to'] = $tripPlan['yard'];
                    break;

                default:
                    $batch['trip_type'] = TripPlanTypeEnum::TRIP_PLAN_LOADED;
                    $batch['start_from'] = $tripPlan['pick_up_from'];
                    $batch['finish_to'] = $tripPlan['destination'];
                    break;
            }
            $this->tripPlans[$i] = $batch;
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

            foreach ($this->tripPlans as $tripPlan) {
                $model = new PlanTrip();
                $model->start_from = $tripPlan['start_from'];
                $model->finish_to = $tripPlan['finish_to'];
                $model->trip_type = $tripPlan['trip_type'];
                $model->post_id = $this->postId;
                $model->save();
            }
            PlanOrder::query()
                ->where('post_id', '=', $this->postId)
                ->update(['trip' => $this->tripTimes]);

            $userCurrentPost = [
                'steps' => '0;1;2;3;4',
                'step_at' => 4,
                'url' => WorkOrder::ROUTE_NAME.'.blueprint'
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
        return view('livewire.'.PlanTrip::ROUTE_NAME.'.create');
    }
}
