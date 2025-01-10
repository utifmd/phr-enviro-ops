<?php

namespace App\Utils;

enum WorkTripDetailTypeEnum: string
{
    case DRILLING = 'Drilling Site';
    case MUD_PIT = 'Mud Pit Closure';
    case TREATED_WATER = 'Treated Water';
    case CONCENTRATED_WATER = 'Concentrated Water';
}
