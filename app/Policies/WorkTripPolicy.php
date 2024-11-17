<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class WorkTripPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    const IS_WORK_TRIP_CREATED = 'isWorkTripCreated';
    public function isWorkTripCreated(User $user, Post $post): bool
    {
        return $post->workTrip != null;
    }
}
