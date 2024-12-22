<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
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
    public function getTripByDateAndArea(string $date, string $area): array;
    public function getActualTripByPostId(string $postId): array;
    public function getActualTripByTimeAndPostId(string $time, string $postId): array;
    public function getTripByDatetime(string $date, string $time): array;
    public function getTripByDatetimeAndArea(string $date, string $time, string $area): array;
    public function sumTripByArea(string $area): LengthAwarePaginator;
    public function getTrips(): LengthAwarePaginator;
    public function areTripsExistByDate(string $date): bool;
    public function areTripsExistByDateAndArea(string $date, string $area): bool;
    public function areTripsExistByDatetime(string $date, string $time): bool;
    public function areTripsExistByDatetimeAndArea(string $date, string $time, string $area): bool;
    public function areTripsExistByDatetimeOrDatesTimeAndArea($dateOrDates, $timeOrTimes, string $area): bool;

    public function sumInfoAndTripByArea(string $area): LengthAwarePaginator;

    public function addInfo(array $workTripInfo): void;
    public function updateInfo(array $workTripInfo): void;
    public function removeInfoById(string $id): void;
    public function getInfoByDate(string $date): array;
    public function getInfoByDateAndArea(string $date, string $area): array;
    public function getInfoByDateOrDatesAndArea($dateOrDates, string $area): array;
    public function getInfoByDatetime(string $date, string $time): array;
    public function getInfoByDatetimeAndArea(string $date, string $time, string $area): array;
    public function getInfoByDatetimeOrDatesTimeAndArea($dateOrDates, $timeOrTimes, string $area): array;
    public function sumInfoByArea(string $area): LengthAwarePaginator;
    public function getInfos(): LengthAwarePaginator;
    public function areInfosExistByDate(string $date): bool;
    public function areInfosExistByDateOrDatesAndArea($dateOrDates, string $area): bool;
    public function areInfosExistByDateAndArea(string $date, string $area): bool;
    public function areInfosExistByDatetime(string $date, string $time): bool;
    public function areInfosExistByDatetimeAndArea(string $date, string $time, string $area): bool;
    public function areInfosExistByDatetimeOrDatesTimeAndArea($dateOrDates, $timeOrTimes, string $area): bool;

    public function getLatestInfosDateByArea(string $area): ?string;
    public function getLatestInfosDateByDateOrDatesAndArea($dateOrDates, string $area): ?string;

    public function mapTripPairActualValue(array $tripState): array;
    public function mapPairInfoAndTripActualValue(array $infos, array $tripState): array;
    public function mapTripUnpairActualValue(array $tripState): array;

    public function sumActualByAreaAndDate(string $areaName, string $date): int;

    public function addNotes(string $postId, string $userId, string $message): void;
    public function addNotesWithProps(array $props): void;
    public function getNotesByDateAndUserId(string $date, string $userId): array;
    public function areNotesByDateAndUserIdExist(string $userId, string $date): bool;
    public function updateNotesByDateAndUserId(string $userId, string $date, string $message): void;
    public function updateNotesByPostId(string $id, string $message): void;

    public function countPendingWorkTrip(array $workTrips): int;

    public function getNotesByArea(string $areaName): Collection;

    public function getNotesByDateArea(string $areaName, string $startDate, string $endDate): Collection;
}
