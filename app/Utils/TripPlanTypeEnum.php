<?php

namespace App\Utils;

enum TripPlanTypeEnum: string
{
    case TRIP_PLAN_EMPTY = "EMPTY TRIP";
    case TRIP_PLAN_LOADED = "LOADED TRIP";
    case TRIP_PLAN_BTB = "BACK TO BASE";
}
