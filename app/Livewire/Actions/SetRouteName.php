<?php

namespace App\Livewire\Actions;

use App\Models\PostWoExistingProc;

class SetRouteName
{
    public function __invoke(string $postId, string $userId): void
    {
        PostWoExistingProc::factory()->create([
            'user_id' => $userId, 'post_id' => $postId
        ]);
    }
}
