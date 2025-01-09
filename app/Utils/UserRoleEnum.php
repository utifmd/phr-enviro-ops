<?php

namespace App\Utils;

enum UserRoleEnum: string
{
    case DEV_ROLE = "USER_DEV_ROLE";
    case FAC_REP_MK_ROLE = "USER_FAC_REP_MK_ROLE";
    case PLANNER_ROLE = "USER_PLANNER_ROLE";
    case PM_COW_ROLE = "USER_PMCOW_ROLE";
    case VT_CREW_ROLE = "USER_VT_CREW_ROLE";
    case GUEST_ROLE = "USER_GUEST_ROLE";
}
