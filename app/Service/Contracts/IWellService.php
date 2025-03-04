<?php

namespace App\Service\Contracts;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface IWellService
{
    function addNewWell(
        array $postRequest,
        array $uploadedUrlRequest,
        array $workOrdersRequest): ?Post;

    function updateWell(
        array $postRequest,
        array $imageUrlRequest,
        array $workOrdersRequest): ?Post;

    function getWellPostById(string $postId): ?Post;
    function getRecapPerMonth(string $year, string $month): ?array;
    function getCurUserLoadVTRequest(): array;
    function getPtLoadVtRequest(): array;

    function pagedWellPost(?bool $isBypassed, ?string $idsWellName): LengthAwarePaginator;
    function pagedWellPostBy(string $date): LengthAwarePaginator;

    /*function searchWellPostByName(string $wellName): ?Post;
    function removeWellPost(string $wellId): bool;*/

    function pagedWellMaster(?string $query, ?int $page): LengthAwarePaginator;

    function removeWellMasterBy(string $id): bool;

    function getRecapPerDayByScope(int $scope): ?array;
}
