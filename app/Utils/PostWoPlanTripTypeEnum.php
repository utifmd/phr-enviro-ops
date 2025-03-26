<?php

namespace App\Utils;

enum PostWoPlanTripTypeEnum: string
{
    case EMPTY = "EMPTY TRIP";
    case LOADED = "LOADED TRIP";
    case BTB = "BACK TO BASE";
}
