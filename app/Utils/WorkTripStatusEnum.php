<?php

namespace App\Utils;

enum WorkTripStatusEnum: string
{
    case PENDING = 'Pending';
    case APPROVED = 'Approved';
    case REJECTED = 'Rejected';
    case DISPOSITION = 'Disposition';
}
