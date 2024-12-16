<?php

namespace App\Repositories;

use App\Models\Log;
use App\Repositories\Contracts\ILogRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class LogRepository implements ILogRepository
{
    public function getLogs(): LengthAwarePaginator
    {
        return Log::query()
            ->orderByDesc('created_at')
            ->paginate();
    }

    public function getLogsByArea(string $area): LengthAwarePaginator
    {
        return Log::query()
            ->where('area', $area)
            ->orderByDesc('created_at')
            ->paginate();
    }
    public function addLogs(
        string $urlPath, string $highlight, ?string $event = null, ?string $areaName = null): void
    {
        $data = [
            'event' => $event ?? $highlight,
            'highlight' => $highlight,
            'route_name' => $urlPath,
            'url' => env('APP_URL').'/'.$urlPath,
            'user_id' => \auth()->id(),
        ];
        if (!is_null($area = $areaName ?? \auth()->user()->area_name)){
            $data['area'] = $area;
        }
        if(!is_null($event)) $data['event'] = $event;

        Log::factory()->create($data);
    }
}
