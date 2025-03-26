<?php

namespace App\Http\Controllers;

use App\Http\Resources\LogResource;
use App\Http\Resources\WorkTripNoteResource;
use App\Repositories\Contracts\ILogRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Service\LogService;
use App\Service\WorkTripService;
use App\Utils\AreaNameEnum;
use App\Utils\PostFacReportStatusEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostRemarksController extends Controller
{
    private IWorkTripRepository $wtRepos;

    public function __construct(IWorkTripRepository $wtRepos)
    {
        $this->wtRepos = $wtRepos;

        $this->initAuthUser();
    }

    private function initAuthUser(): void
    {
        // $this->authUsr = $this->usrRepos->authenticatedUser()->toArray();
    }

    public function index(Request $request): JsonResponse
    {
        $data = $this->wtRepos->getNotesByArea(
            AreaNameEnum::AllArea->value
        );
        $message = 'latest update ';
        $message .= date('d/m/y H:i:s');

        return WorkTripService::sendResponse(
            WorkTripNoteResource::collection($data), $message
        );
    }

    public function show(string $strToTime): JsonResponse
    {
        try {
            $startDate = date('Y-m-d', strtotime($strToTime));

        } catch (\Exception) {
            $startDate = date('Y-m-d', strtotime('-1 month'));
        }
        $endDate = date('Y-m-d');

        $data = $this->wtRepos->getNotesByDateArea(
            AreaNameEnum::AllArea->value, $startDate, $endDate
        );
        $message = 'latest update ';
        $message .= date("d/m/y H:i:s");

        return WorkTripService::sendResponse(
            WorkTripNoteResource::collection($data), $message
        );
    }
}
