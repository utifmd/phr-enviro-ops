<?php

namespace App\Livewire\WorkTrips\Request;

use App\Livewire\Forms\PostForm;
use App\Models\Post;
use App\Policies\UserPolicy;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\WorkTripStatusEnum;
use App\Utils\WorkTripTypeEnum;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    private IWorkTripRepository $wtRepos;
    public PostForm $form;
    public array $workTrips, $tripIdsQueue = [];

    public function mount(Post $post): void
    {
        $this->form->setPostModel($post);
        $this->initWorkTrips($post->workTrips);
    }

    public function booted(IWorkTripRepository $wtRepos): void
    {
        $this->wtRepos = $wtRepos;
    }

    private function initWorkTrips(Collection $workTrips): void
    {
        $this->workTrips = array();
        // $this->workTrips = $workTrips->toArray();
        foreach ($workTrips as $actualTrip) {
            // if ($actualTrip->type != WorkTripTypeEnum::ACTUAL->value) continue;
            $this->tripIdsQueue[] = $actualTrip->id;
            $this->workTrips[] = $actualTrip;
        }
        /*foreach ($workTrips as $i => $planTrip) {
            //if ($actualTrip->type != WorkTripTypeEnum::PLAN->value) continue;
            if ($actualTrip->time != $planTrip->time) continue;
            $actPlanVal = $actualTrip->act_value . '/' . $planTrip->act_value;
            break;
        }*/
    }

    private function mapWorkTrip(
        string $id, array $current, array $request): array
    {
        foreach ($current as $trip) {
            if($trip['id'] != $id) continue;

            $trip['status'] = $request['status'];
        }
        return $current;
    }

    /**
     * @throws AuthorizationException
     */
    public function onChangeStatus(string|array $idOrIds, string $request): void
    {
        $this->authorize(UserPolicy::IS_USER_IS_FAC_REP, $this->form->postModel);

        $onComplete = function ($id) use ($request) {
            $request = ['id' => $id, 'status' => $request];
            $this->workTrips = $this->mapWorkTrip($id, $this->workTrips, $request);
            $this->wtRepos->updateTrip($request);
        };
        if (is_string($id = $idOrIds)) $onComplete($id);
        if (!is_array($idOrIds)) return;
        foreach ($idOrIds as $id) { $onComplete($id); }
    }

    /**
     * @throws AuthorizationException
     */
    public function onAllowAllRequestPressed(): void
    {
        $this->onChangeStatus(
            $this->tripIdsQueue,
            WorkTripStatusEnum::APPROVED->value
        );
    }
    /**
     * @throws AuthorizationException
     */
    public function onDeniedAllRequestPressed(): void
    {
        $this->onChangeStatus(
            $this->tripIdsQueue,
            WorkTripStatusEnum::REJECTED->value
        );
    }
    /*public function onDeletePressed(string $postId): void
    {
        try {
            $this->form->onRemoveEvidences(function (array $paths) {
                foreach ($paths as $path) { unlink(storage_path($path)); }
            });
        } catch (\Throwable $throwable){
            Log::debug($throwable->getMessage());

        } finally {
            $this->postRepository->removePost($postId);
            $this->redirectRoute('work-trips.index');
        }
    }*/

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip.request.show');
    }
}
