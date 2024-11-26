<?php

namespace App\Service;

use App\Models\ImageUrl;
use App\Models\Post;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWellMasterRepository;
use App\Repositories\Contracts\IWorkOrderRepository;
use App\Service\Contracts\IWellService;
use App\Utils\Contracts\IUtility;
use App\Utils\WorkOrderStatusEnum;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class WellService implements IWellService
{
    private IPostRepository $postRepository;
    private IWorkOrderRepository $workOrderRepository;
    private IWellMasterRepository $wellMasterRepository;
    private IUtility $utility;
    private ?string $userId = null;

    public function __construct(
        IPostRepository $postRepository,
        IWorkOrderRepository $workOrderRepository,
        IUserRepository $userRepository,
        IWellMasterRepository $wellMasterRepository,
        IUtility $utility)
    {
        $this->userId = $userRepository->authenticatedUser()->id;
        $this->postRepository = $postRepository;
        $this->workOrderRepository = $workOrderRepository;
        $this->wellMasterRepository = $wellMasterRepository;
        $this->utility = $utility;
    }

    function addNewWell(
        array $postRequest, array $uploadedUrlRequest, array $workOrdersRequest): ?Post {
        $post = null;
        $this->postRepository->async();
        try {
            $postOrNull = $this->postRepository
                ->addPost($postRequest);

            if (is_null($postOrNull)) return null;
            $postId = $postOrNull->id;

            ImageUrl::factory()->create(['post_id' => $postId]);

            foreach ($workOrdersRequest as $workOrderRequest) {
                $workOrderRequest['post_id'] = $postId;
                $this->workOrderRepository
                    ->addWorkOrder($workOrderRequest);
            }
            $post = $this->postRepository
                ->getPostById($postId);

            $this->postRepository->await();
        } catch (\Throwable $throwable){

            Log::debug($throwable->getMessage());
            $this->postRepository->cancel();
        }
        return $post;
    }

    public function updateWell(
        array $postRequest, array $imageUrlRequest, array $workOrdersRequest): ?Post {
        $post = null;
        $this->postRepository->async();
        try {
            $postOrNull = $this->postRepository->updatePost($postRequest['id'], $postRequest);

            if (is_null($postOrNull)) return null;
            $postId = $postRequest['id']; //$postOrNull->id;

            ImageUrl::query()->find($imageUrlRequest['id'])->update($imageUrlRequest);

            if (count($workOrdersRequest) > 0) {
                $this->workOrderRepository->removeWorkOrderBy($postId); // ?? throw new \Exception('remove work order failed.');

                foreach ($workOrdersRequest as $workOrder) {
                    $workOrder['post_id'] = $postId;
                    $this->workOrderRepository->addWorkOrder($workOrder); // ?? throw new \Exception('add work order failed.');
                }
            }
            $post = $this->postRepository
                ->getPostById($postId);

            $this->postRepository->await();
        } catch (\Throwable $throwable){

            Log::debug('transaction: '. $throwable->getMessage());
            $this->postRepository->cancel();
        }
        return $post;
    }

    function getWellPostById(string $postId): ?Post
    {
        return $this->postRepository->getPostById($postId);
    }

    public function getRecapPerMonth(string $year, string $month): ?array
    {
        $days = $this->utility->datesOfTheMonth();
        $names = $this->workOrderRepository->getWorkOrdersNameByMonth($year, $month)->all();
        $view = ['data' => []];
        foreach ($names as $i => $name){

            $isRig = $name['is_rig'];
            $loads = $this->workOrderRepository->getWorkOrdersLoadBy($year, $month, $name['ids_wellname'], $isRig)->all();
            $combinedDashboard = $this->utility->combineDashboardArrays($loads, $days);
            $combinedDashboard["num"] = $i +1;
            $combinedDashboard["ids_wellname"] = $name['ids_wellname'];
            $combinedDashboard["well_number"] = $name['ids_wellname'] . ($isRig ? '' : ' (Non Rig)');
            $combinedDashboard["wbs_number"] = $name['wbs_number'];

            $view['data'][] = $combinedDashboard;
            $view['grand_total'] =+ $combinedDashboard['total'];
        }
        $view['days'] = $days;
        return $view;
    }
    public function getRecapPerDayByScope(int $scope): ?array
    {
        return $this->workOrderRepository->countWorkOrdersByScope($scope)->toArray(); //->all() ~> bug
    }

    public function pagedWellPost(
        ?bool $isBypassed = null, ?string $idsWellName = null): LengthAwarePaginator
    {
        if ($isBypassed) return $this->postRepository->pagedPosts($idsWellName);

        return $this->postRepository->pagedPostByUserId($this->userId);
    }

    function pagedWellMaster(?string $query, ?int $page = null): LengthAwarePaginator
    {
        if (!is_null($query))
            return $this->wellMasterRepository->pagingSearchWellMaster($query);

        return $this->wellMasterRepository->pagingWellMaster();
    }

    public function removeWellMasterBy(string $id): bool
    {
        return $this->wellMasterRepository->delete($id);
    }
    public function getCurUserLoadVTRequest(): array
    {
        $total_count = $this->postRepository->countLoadPostBy($this->userId);

        $accepted_count = $this->postRepository->countLoadPostBy(
            $this->userId, WorkOrderStatusEnum::STATUS_ACCEPTED->value
        );
        $rejected_count = $this->postRepository->countLoadPostBy(
            $this->userId, WorkOrderStatusEnum::STATUS_REJECTED->value
        );
        $pending_request = max(
            $total_count - ($rejected_count + $total_count), 0
        );
        return compact(
            'total_count', 'accepted_count', 'rejected_count', 'pending_request'
        );
    }

    function getPtLoadVtRequest(): array
    {
        $total_count = $this->postRepository->countLoadPostBy();

        $accepted_count = $this->postRepository->countLoadPostBy(
            null, WorkOrderStatusEnum::STATUS_ACCEPTED->value
        );
        $rejected_count = $this->postRepository->countLoadPostBy(
            null, WorkOrderStatusEnum::STATUS_REJECTED->value
        );
        $pending_request = max(
            $total_count - ($rejected_count + $total_count), 0
        );
        return compact(
            'total_count', 'accepted_count', 'rejected_count', 'pending_request'
        );
    }
}
