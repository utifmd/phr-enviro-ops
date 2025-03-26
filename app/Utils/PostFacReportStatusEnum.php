<?php

namespace App\Utils;

enum PostFacReportStatusEnum: string
{
    case PENDING = 'Pending';
    case APPROVED = 'Approved';
    case REJECTED = 'Rejected';
    case DISPOSITION = 'Disposition';
}
