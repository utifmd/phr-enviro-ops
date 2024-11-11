<?php

namespace App\Livewire\Actions;

use App\Models\UserCurrentPost;

class SetRouteName
{
    public function __invoke(string $postId, string $userId): void
    {
        UserCurrentPost::factory()->create([
            'user_id' => $userId, 'post_id' => $postId
        ]);
    }
}
