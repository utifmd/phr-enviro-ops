<?php

namespace App\Utils\Contracts;

use App\Models\Post;

interface IUtility
{
    function daysOfMonthLength(?int $month): int|false;
    function datesOfTheMonthBy(int $daysOfMonthLength): array;
    function datesOfTheMonth(?int $count): array;
    function timeAgo(string $datetime): string;
    function transporter(mixed $operator): string;
    function nameOfMonth(string $numOfMonth): string;
    function combineDashboardArrays(array $loads, array $days): array;

    function countWoPendingRequest(Post $post): int;
}