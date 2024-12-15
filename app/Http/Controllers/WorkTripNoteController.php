<?php

namespace App\Http\Controllers;

use App\Http\Resources\LogResource;
use App\Http\Resources\WorkTripNoteResource;
use App\Repositories\Contracts\ILogRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Service\LogService;
use App\Service\WorkTripService;
use App\Utils\AreaNameEnum;
use App\Utils\WorkTripStatusEnum;
use Illuminate\Http\JsonResponse;

class WorkTripNoteController extends Controller
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

    public function index(): JsonResponse
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
}
