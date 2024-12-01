<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IWorkTripRepository
{
    public function index(): Collection;
    public function indexByStatus(string $status): Collection;
    public function getById($id): Collection;
    public function store(array $data): Collection;
    public function update(array $data,$id): bool;
    public function delete($id): ?bool;

    function getProcessOptions(?string $actName): array;
    function getLocationsOptions(?string $areaName): array;
    function getLocations(string $areaName): array;
    public function getByPostId($id): Collection;


    public function addTrip(array $workTripTrip): void;
    public function updateTrip(array $workTripTrip): void;
    public function removeTripById(string $id): void;
    public function getTripByDate(string $date): array;
    public function getTripByDatetime(string $date, string $time): array;
    public function sumTripByArea(string $area): LengthAwarePaginator;
    public function getTrips(): LengthAwarePaginator;
    public function areTripsExistByDate(string $date): bool;
    public function areTripsExistByDatetime(string $date, string $time): bool;

    public function sumInfoAndTripByArea(string $area): LengthAwarePaginator;

    public function addInfo(array $workTripInfo): void;
    public function updateInfo(array $workTripInfo): void;
    public function removeInfoById(string $id): void;
    public function getInfoByDate(string $date): array;
    public function getInfoByDatetime(string $date, string $time): array;
    public function sumInfoByArea(string $area): LengthAwarePaginator;
    public function getInfos(): LengthAwarePaginator;
    public function areInfosExistBy(string $date): bool;

    public function mapTripPairActualValue(array $tripState): array;
    public function mapTripUnpairActualValue(array $tripState): array;

    public function sumActualByAreaAndDate(string $areaName, string $date): int;
}
