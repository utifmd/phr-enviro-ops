<?php

namespace App\Utils;

enum PostWoStatusEnum: string
{
    case STATUS_PENDING = 'PENDING';
    case STATUS_REJECTED = 'REJECTED';
    case STATUS_ACCEPTED = 'ACCEPTED';
}
