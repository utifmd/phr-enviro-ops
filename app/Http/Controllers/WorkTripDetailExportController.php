<?php

namespace App\Http\Controllers;

use App\Exports\WorkTripDetailExport;
use App\Policies\UserPolicy;
use App\Repositories\Contracts\IWorkTripRepository;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WorkTripDetailExportController extends Controller
{
    public function export(
        IWorkTripRepository $wtRepos, string $type, string $date): BinaryFileResponse
    {
        Gate::authorize(UserPolicy::IS_USER_IS_FAC_OPE_N_DEV);

        $filename = 'VT Log Sheet Report ' . $date . '.xlsx';

        $wtDetailExport = new WorkTripDetailExport(
            $wtRepos, $type, $date
        );
        return Excel::download($wtDetailExport, $filename);
    }
}
