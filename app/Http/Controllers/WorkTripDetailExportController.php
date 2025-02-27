<?php

namespace App\Http\Controllers;

use App\Exports\WorkTripDetailExport;
use App\Policies\UserPolicy;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\WorkTripTypeEnum;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WorkTripDetailExportController extends Controller
{
    public function export(
        IWorkTripRepository $wtRepos/*, string $type*/, string $date): BinaryFileResponse
    {
        $filename = 'VT Log Sheet Report ' . $date . '.xlsx';
        $type = WorkTripTypeEnum::ACTUAL->value;
        $wtDetailExport = new WorkTripDetailExport(
            $wtRepos, $type, $date
        );
        return Excel::download($wtDetailExport, $filename);
    }
}
