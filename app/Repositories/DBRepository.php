<?php

namespace App\Repositories;

use App\Models\Operator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DBRepository implements Contracts\IDBRepository
{
    function async(): void
    {
        DB::beginTransaction();
    }

    function await(): void
    {
        DB::commit();
    }

    function cancel(): void
    {
        DB::rollBack();
    }
}
