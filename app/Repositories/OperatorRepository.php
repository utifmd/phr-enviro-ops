<?php

namespace App\Repositories;

use App\Models\Operator;
use Illuminate\Support\Collection;

class OperatorRepository implements Contracts\IOperatorRepository
{
    function getOperators(): Collection
    {
        return Operator::query()->get();
    }
    function getOperatorsOptions(): Collection
    {
        return $this->getOperators()->transform(function (Operator $operator) {
            $operator->value = $operator->id;
            return $operator;
        });
    }
}
