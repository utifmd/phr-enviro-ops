<?php

namespace App\Repositories;

use App\Models\PostWoExistingProc;
use App\Repositories\Contracts\IUserCurrentPostRepository;
use Illuminate\Support\Collection;

class UserCurrentPostRepository implements IUserCurrentPostRepository
{
    function update(string $userId, array $data): ?Collection
    {
        $builder = PostWoExistingProc::query()->where(
            'user_id', '=', $userId
        );
        $model = $builder->get();

        if ($model->isEmpty()) return null;
        if ($builder->update($data) < 1) return null;

        return $model;
    }
}
