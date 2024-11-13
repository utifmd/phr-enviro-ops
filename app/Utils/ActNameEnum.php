<?php

namespace App\Utils;

enum ActNameEnum: string
{
    case Incoming = 'Incoming';
    case Outgoing = 'Outgoing';
    case Production = 'Production';
}
