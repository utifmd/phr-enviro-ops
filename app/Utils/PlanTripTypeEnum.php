<?php

namespace App\Utils;

enum PlanTripTypeEnum: string
{
    case EMPTY = "EMPTY TRIP";
    case LOADED = "LOADED TRIP";
    case BTB = "BACK TO BASE";
}
