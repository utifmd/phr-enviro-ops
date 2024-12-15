<?php

namespace App\Http\Resources;

use App\Utils\Constants;
use App\Utils\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkTripNoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $createdAt = $this->post->created_at ?? Constants::EMPTY_STRING;
        $createdAt = Carbon::parse($createdAt)->format('M d, h:i A');
        $username = $this->user->name ?? 'some user';
        $username = $createdAt.', '. $username . ': ';
        return [
            'message' => $this->message,
            'user' => $username
        ];
    }
}
