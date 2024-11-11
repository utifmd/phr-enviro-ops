<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    const IS_USER_HAS_CURRENT_POST = "isUserHasCurrentPost";
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function isUserHasCurrentPost(User $user): bool
    {
        return isset($user->currentPost) && !is_null($user->currentPost);
    }
}
