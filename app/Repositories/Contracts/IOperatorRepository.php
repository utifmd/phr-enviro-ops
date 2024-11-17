<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface IOperatorRepository
{
    function getOperators(): Collection;
    function getOperatorsOptions(): array;
    function getVehicleTypesOptions(): array;
}
