<?php

namespace App\Repositories\Contracts;

use App\Models\UserCurrentPost;
use Illuminate\Support\Collection;

interface IUserCurrentPostRepository
{
    function update(string $userId, array $data): ?Collection;
}
