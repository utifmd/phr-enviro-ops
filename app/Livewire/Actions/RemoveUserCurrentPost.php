<?php

namespace App\Livewire\Actions;

use App\Models\UserCurrentPost;

class RemoveUserCurrentPost
{
    public function execute(string $userId): void
    {
        $model = UserCurrentPost::query()->where(
            'user_id', '=', $userId
        );
        if ($model->get()->isEmpty()) return;

        $model->delete();
    }
}
