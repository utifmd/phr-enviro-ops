<?php

namespace App\Policies;

use App\Models\User;
use App\Utils\UserRoleEnum;

class UserPolicy
{
    const IS_USER_IS_PM_COW_N_DEV = 'isUserIsPmCowAndDev';
    const IS_USER_IS_PM_COW = 'isUserIsPmCow';
    const IS_USER_IS_VT_CREW = 'isUserIsVtCrew';
    const IS_USER_IS_VT_CREW_N_DEV = 'isUserIsVtCrewAndDev';

    const IS_USER_IS_FAC_REP = 'isUserIsFacRep';
    const IS_USER_IS_PLANNER = 'isUserIsPlanner';

    const IS_NOT_GUEST_ROLE = 'isUserRoleIsNotGuest';


    const IS_DEV_ROLE = 'isUserRoleIsDev';

    const IS_USER_HAS_CURRENT_POST = "isUserHasCurrentPost";
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }


    public function isUserIsPlanner(User $user): bool
    {
        return $user->role == UserRoleEnum::PLANNER_ROLE->value ||
            $user->role == UserRoleEnum::DEV_ROLE->value;
    }
    public function isUserIsFacRep(User $user): bool
    {
        return $user->role == UserRoleEnum::FAC_REP_MK_ROLE->value ||
            $user->role == UserRoleEnum::DEV_ROLE->value;
    }
    public function isUserIsPmCowAndDev(User $user): bool
    {
        return $user->role == UserRoleEnum::PM_COW_ROLE->value ||
            $user->role == UserRoleEnum::DEV_ROLE->value;
    }
    public function isUserIsVtCrewAndDev(User $user): bool
    {
        return $user->role == UserRoleEnum::VT_CREW_ROLE->value ||
            $user->role == UserRoleEnum::DEV_ROLE->value;
    }
    public function isUserIsPmCow(User $user): bool
    {
        return $user->role == UserRoleEnum::PM_COW_ROLE->value;
    }
    public function isUserIsVtCrew(User $user): bool
    {
        return $user->role == UserRoleEnum::VT_CREW_ROLE->value;
    }
    public function isUserHasCurrentPost(User $user): bool
    {
        return isset($user->currentPost) && !is_null($user->currentPost);
    }

    public function isUserRoleIsDev(User $user): bool {
        return $user->role == UserRoleEnum::DEV_ROLE->value;
    }

    public function isUserRoleIsNotGuest(User $user): bool
    {
        return $user->role != UserRoleEnum::GUEST_ROLE->value;
    }
}
