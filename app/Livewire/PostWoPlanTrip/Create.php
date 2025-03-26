<?php

namespace App\Livewire\PostWoPlanTrip;

use App\Livewire\Actions\GetStep;
use App\Livewire\Actions\RemoveUserCurrentPost;
use App\Livewire\Forms\PlanTripForm;
use App\Models\Post;
use App\Models\PostWoPlanTrip;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public PlanTripForm $form;
    private Authenticatable $user;
    private GetStep $getStep;
    private RemoveUserCurrentPost $removeUserCurrentPost;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->getStep = new GetStep($this->user);
        $this->removeUserCurrentPost = new RemoveUserCurrentPost();
    }

    public function mount(PostWoPlanTrip $tripPlan): void
    {
        $currentPost = $this->user->currentPost ?? null;
        if (!$currentPost) return;

        $postId = $currentPost->post_id;
        $build = PostWoPlanTrip::query()
            ->where('post_id', '=', $postId)
            ->get();

        $tripPlanModel = $build->isNotEmpty()
            ? $build->first()
            : $tripPlan;

        $tripPlanModel->post_id = $postId;
        $this->form->setPlanTripModel($tripPlanModel);
    }

    public function save(): void
    {
        $this->form->store();

        $this->redirectRoute('trip-plans.index', navigate: true);
    }

    public function addTripPlanThenFinish(): void
    {
        $this->form->store();
        $this->removeUserCurrentPost->execute(
            $this->user->getAuthIdentifier()
        );
        session()->flash(
            'message', 'Show Orders successfully submitted, please follow the next step!'
        );
        $this->redirectRoute(Post::ROUTE_NAME.'.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $steps = $this->getStep->getSteps();
        $stepAt = $this->getStep->getStepAt();
        $disabled = in_array(PostWoPlanTrip::ROUTE_POS, $steps) && $stepAt != PostWoPlanTrip::ROUTE_POS;

        return view('livewire.'.PostWoPlanTrip::ROUTE_NAME.'.create', compact(
            'steps', 'stepAt', 'disabled'
        ));
    }
}
