<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface ICrewRepository
{
    function getCrews(?string $operatorId): Collection;
    function getCrewsOptions(?string $operatorId): Collection;
}
