<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkTripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'date' => $this->date,
            'time' => $this->time,
            'act_name' => $this->act_name,
            'act_process' => $this->act_process,
            'act_unit' => $this->act_unit,
            'act_value' => $this->act_value,
            'area_name' => $this->area_name,
            'area_loc' => $this->area_loc //, 'post_id'
        ];
    }
}
