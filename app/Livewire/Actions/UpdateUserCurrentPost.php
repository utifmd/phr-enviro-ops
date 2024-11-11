<?php

namespace App\Livewire\Actions;

use App\Models\UserCurrentPost;

class UpdateUserCurrentPost
{
    public function __invoke(string $userId, array $data): void
    {
        $model = UserCurrentPost::query()->where(
            'user_id', '=', $userId
        );
        if ($model->get()->isEmpty()) return;

        $model->update($data);
    }
}
