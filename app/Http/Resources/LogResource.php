<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $username = $this->user->name ?? 'some user';
        return [
            'highlight' => $username.': '.$this->highlight,
            'event' => $username.' just '.$this->event,
            'area' => $this->area,
            'username' => $username,
            'created_at' => $this->created_at
        ];
    }
}
