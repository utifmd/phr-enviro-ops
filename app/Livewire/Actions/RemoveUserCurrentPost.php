<?php

namespace App\Livewire\Actions;

use App\Models\PostWoExistingProc;

class RemoveUserCurrentPost
{
    public function execute(string $userId): void
    {
        $model = PostWoExistingProc::query()->where(
            'user_id', '=', $userId
        );
        if ($model->get()->isEmpty()) return;

        $model->delete();
    }
}
