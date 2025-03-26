<?php

namespace App\Repositories\Contracts;

use App\Models\PostWo;
use Illuminate\Support\Collection;

interface IWorkOrderRepository
{
    function addWorkOrder(array $request): ?PostWo;

    // function getWorkOrderByPostId(string $id): Collection;
    function getWorkOrdersByDepartmentId(string $id): Collection;
    function getWorkOrdersByOperatorId(string $id): Collection;
    function getWorkOrdersByVehicleId(string $id): Collection;

    function getWorkOrdersLoadBy(string $year, string $month, string $idsWellName, bool $isRig): Collection;
    function getWorkOrdersNameByMonth(string $year, string $month): Collection;

    function countWorkOrdersByScope(int $scope): Collection;

    function searchWorkOrderByWell(
        string $wellNumber, ?string $wbsNumber, ?string $createdDate, ?string $createdTime): Collection;

    // function searchWorkOrderBySize(int $page, int $size): Collection;
    function updateWorkOrder(string $workOrderId, array $request): ?PostWo;
    function removeWorkOrder(string $workOrderId): bool;
    function removeWorkOrderBy(string $postId): bool;
}
