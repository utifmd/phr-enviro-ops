<?php

namespace App\Livewire\TripPlans;

use App\Livewire\Actions\GetStep;
use App\Livewire\Actions\RemoveUserCurrentPost;
use App\Livewire\Forms\TripPlanForm;
use App\Models\Post;
use App\Models\TripPlan;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public TripPlanForm $form;
    private Authenticatable $user;
    private GetStep $getStep;
    private RemoveUserCurrentPost $removeUserCurrentPost;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->getStep = new GetStep($this->user);
        $this->removeUserCurrentPost = new RemoveUserCurrentPost();
    }

    public function mount(TripPlan $tripPlan): void
    {
        $currentPost = $this->user->currentPost ?? null;
        if (!$currentPost) return;

        $postId = $currentPost->post_id;
        $build = TripPlan::query()
            ->where('post_id', '=', $postId)
            ->get();

        $tripPlanModel = $build->isNotEmpty()
            ? $build->first()
            : $tripPlan;

        $tripPlanModel->post_id = $postId;
        $this->form->setTripPlanModel($tripPlanModel);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('trip-plans.index', navigate: true);
    }

    public function addTripPlanThenFinish(): void
    {
        $this->form->store();
        $this->removeUserCurrentPost->execute(
            $this->user->getAuthIdentifier()
        );
        session()->flash(
            'message', 'Detail Orders successfully submitted, please follow the next step!'
        );
        $this->redirectRoute(Post::ROUTE_NAME.'.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $steps = $this->getStep->getSteps();
        $stepAt = $this->getStep->getStepAt();
        $disabled = in_array(TripPlan::ROUTE_POS, $steps) && $stepAt != TripPlan::ROUTE_POS;

        return view('livewire.trip-plan.create', compact(
            'steps', 'stepAt', 'disabled'
        ));
    }
}
