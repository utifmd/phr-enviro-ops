<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IWorkTripRepository
{
    public function index(): Collection;
    public function getById($id): Collection;
    public function store(array $data): Collection;
    public function update(array $data,$id): bool;
    public function delete($id): ?bool;

    function getProcessOptions(?string $actName): array;
    function getLocationsOptions(?string $areaName): array;
    function getLocations(string $areaName): array;
    public function getByPostId($id): Collection;

    public function addInfo(array $workTripInfo): void;
    public function updateInfo(array $workTripInfo): void;
    public function removeInfoById(string $id): void;
    public function getInfoByDate(string $date): array;
    public function getInfoByArea(string $area): LengthAwarePaginator;
    public function getInfos(): LengthAwarePaginator;
    public function areInfosExistBy(string $date): bool;
}
