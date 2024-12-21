<?php

namespace App\Http\Resources;

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
        $date = $this->updated_at ?? $this->created_at;
        $createdAt = Carbon::parse($date)->format('M d, h:i A');
        $username = $this->user->name ?? 'some user';
        $username = $createdAt.', '. $username . ': ';
        return [
            'message' => $this->message,
            'user' => $username,
            'date' => $date
        ];
    }
}
