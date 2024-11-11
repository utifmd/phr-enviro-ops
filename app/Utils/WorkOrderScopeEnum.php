<?php

namespace App\Utils;

enum WorkOrderScopeEnum: int
{
    case DEP_SCOPE = 0;
    case OPE_SCOPE = 1;
    case VEH_SCOPE = 2;
}
