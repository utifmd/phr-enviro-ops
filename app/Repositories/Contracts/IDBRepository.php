<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface IDBRepository
{
    function async(): void;
    function await(): void;
    function cancel(): void;
}
