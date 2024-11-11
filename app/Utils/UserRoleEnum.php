<?php

namespace App\Utils;

enum UserRoleEnum: string
{
    case USER_DEV_ROLE = "USER_DEV_ROLE";
    case FAC_REP_ARK_CMTF_ROLE = "USER_FAC_REP_ARAK_CMTF_ROLE";
    case FAC_REP_BLM_CMTF_ROLE = "USER_FAC_REP_BALAM_CMTF_ROLE";
    case FAC_REP_DRI_CMTF_ROLE = "USER_FAC_REP_DURI_CMTF_ROLE";
    case FAC_REP_MNA_CMTF_ROLE = "USER_FAC_REP_MINAS_CMTF_ROLE";
    case FAC_REP_KB_CMTF_ROLE = "USER_FAC_REP_KOTABATAK_CMTF_ROLE";
    case PLANNER_ROLE = "USER_PLANNER_ROLE";
    case PMCOW_ROLE = "USER_PMCOW_ROLE";
    case USER_GUEST_ROLE = "USER_GUEST_ROLE";
}