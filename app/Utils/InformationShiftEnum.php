<?php

namespace App\Utils;

enum InformationShiftEnum: string
{
    case DAY = 'DAY SHIFT';
    case NIGHT = 'NIGHT SHIFT';
    case ALL = '24 HOUR SHIFT';
}
