<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Equipment;
use Illuminate\Support\Collection;

class OperatorRepository implements Contracts\IOperatorRepository
{
    function getOperators(): Collection
    {
        return Company::query()->get();
    }

    function getOperatorsOptions(): array
    {
        return $this->getOperators()->map(function (Company $operator) {
            $operator->name = trim($operator->prefix.' '.$operator->name.' '.$operator->postfix);
            $operator->value = $operator->id;
            return $operator;
        })->toArray();
    }
}
