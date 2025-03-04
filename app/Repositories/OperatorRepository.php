<?php

namespace App\Repositories;

use App\Models\Operator;
use App\Models\VehicleClass;
use Illuminate\Support\Collection;

class OperatorRepository implements Contracts\IOperatorRepository
{
    function getOperators(): Collection
    {
        return Operator::query()->get();
    }

    function getOperatorsOptions(): array
    {
        return $this->getOperators()->map(function (Operator $operator) {
            $operator->name = trim($operator->prefix.' '.$operator->name.' '.$operator->postfix);
            $operator->value = $operator->id;
            return $operator;
        })->toArray();
    }
}
