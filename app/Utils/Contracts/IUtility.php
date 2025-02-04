<?php

namespace App\Utils\Contracts;

use App\Models\Post;

interface IUtility
{
    function daysOfMonthLength(?int $month): int|false;
    function datesOfTheMonthBy(int $daysOfMonthLength): array;
    function datesOfTheMonth(?int $count): array;
    function datesOfTheMonthOf(string $date): array;
    function getListOfTimes(int $startHour, int $endHour): array;
    function getListOfDates(int $nextDayCount, ?string $startDate): array;
    function getListOfTimesOptions(int $startHour, int $endHour, ?bool $isWholeTime): array;
    function getListOfDatesOptions(int $nextDayCount, ?string $startDate, ?bool $isWholeDate): array;

    function timeAgo(string $datetime): string;
    function transporter(mixed $operator): string;
    function nameOfMonth(string $numOfMonth): string;
    function combineDashboardArrays(array $loads, array $days): array;

    function countWoPendingRequest(Post $post): int;
    function countWtPendingRequest(Post $post): int;

    function addDaysOfParse(?string $latestDate, ?int $dayCount): ?string;

    function convertHtml(string $html): string;
}
