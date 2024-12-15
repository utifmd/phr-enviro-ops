<?php

namespace App\Service;

use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

abstract class Service
{
    /**
     * Create a new class instance.
     */

    public static function throw($e, $message ="Something went wrong! Process not completed"): void
    {
        Log::info($e);
        throw new HttpResponseException(response()->json(["message"=> $message], 500));
    }

    public static function sendResponse($result, $message='Logs retrieved successfully.', $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $result
        ];
        if(!empty($message)) {
            $response['message'] = $message;
        }
        return response()->json($response, $code);
    }
}
