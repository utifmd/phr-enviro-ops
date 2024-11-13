<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IWellMasterRepository
{
    function getWellMasters(int $limit): Collection;
    function getWellMastersByQuery(string $query, ?int $limit): Collection;
    function pagingWellMaster(?int $page): LengthAwarePaginator;
    function pagingSearchWellMaster(string $query): LengthAwarePaginator;
    function delete(string $id): bool;
}
