<?php

namespace App\Http\Controllers;

use App\Exports\WorkTripDetailExport;
use App\Policies\UserPolicy;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\PostFacReportTypeEnum;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PostFacReportController extends Controller
{
    public function export(
        IWorkTripRepository $wtRepos/*, string $type*/, string $date): BinaryFileResponse
    {
        $filename = 'VT Log Sheet Report ' . $date . '.xlsx';
        $type = PostFacReportTypeEnum::ACTUAL->value;
        $wtDetailExport = new WorkTripDetailExport(
            $wtRepos, $type, $date
        );
        return Excel::download($wtDetailExport, $filename);
    }
}
