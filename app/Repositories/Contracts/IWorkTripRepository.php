<?php

namespace App\Repositories\Contracts;

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
    public function getByPostId($id): Collection;
}
