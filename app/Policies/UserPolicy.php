<?php

namespace App\Policies;

use App\Models\User;
use App\Utils\UserRoleEnum;

class UserPolicy
{
    const IS_NOT_GUEST_ROLE = 'isUserRoleIsNotGuest';

    const IS_PT_ROLE = 'isUserRoleIsPT';
    const IS_PT_ONLY_ROLE = 'isUserRoleIsPTOnly';

    const IS_PHR_ROLE = 'isUserRoleIsPhr';

    const IS_DEV_ROLE = 'isUserRoleIsDev';

    const IS_USER_HAS_CURRENT_POST = "isUserHasCurrentPost";
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }


    public function isUserRoleIsPhr(User $user): bool
    {
        return $user->role == UserRoleEnum::FAC_REP_MNA_CMTF_ROLE->value ||
            $user->role == UserRoleEnum::USER_DEV_ROLE->value;
    }
    public function isUserRoleIsPT(User $user): bool
    {
        return $user->role == UserRoleEnum::PMCOW_ROLE->value ||
            $user->role == UserRoleEnum::USER_DEV_ROLE->value;
    }
    public function isUserRoleIsPTOnly(User $user): bool
    {
        return $user->role == UserRoleEnum::PMCOW_ROLE->value;
    }
    public function isUserRoleIsNotGuest(User $user): bool
    {
        return $user->role != UserRoleEnum::USER_GUEST_ROLE->value;
    }
    public function isUserRoleIsDev(User $user): bool {
        return $user->role == UserRoleEnum::USER_DEV_ROLE->value;
    }
    public function isUserHasCurrentPost(User $user): bool
    {
        return isset($user->currentPost) && !is_null($user->currentPost);
    }
}
