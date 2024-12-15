<?php

namespace App\Repositories\Contracts;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ILogRepository
{
    public function getLogs(): LengthAwarePaginator;
    public function getLogsByArea(string $area): LengthAwarePaginator;
    /*public function getById($id): Collection;
    public function store(array $data): Collection;
    public function update(array $data,$id): bool;
    public function delete($id): ?bool;*/
    public function addLogs(string $urlPath, string $highlight, ?string $event);
}
