<?php

namespace App\Http\Controllers;

use App\Http\Resources\LogResource;
use App\Repositories\Contracts\ILogRepository;
use App\Service\LogService;
use App\Utils\WorkTripStatusEnum;
use Illuminate\Http\JsonResponse;

class LogController extends Controller
{
    private ILogRepository $logRepos;

    public function __construct(ILogRepository $logRepos)
    {
        $this->logRepos = $logRepos;

        $this->initAuthUser();
    }

    private function initAuthUser(): void
    {
        // $this->authUsr = $this->usrRepos->authenticatedUser()->toArray();
    }

    public function index(): JsonResponse
    {
        $data = $this->logRepos->getLogs();
        $message = 'latest update ';
        $message .= date('d/m/y H:i:s');

        return LogService::sendResponse(
            LogResource::collection($data), $message
        );
    }
}
