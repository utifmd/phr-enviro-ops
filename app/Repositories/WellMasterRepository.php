<?php

namespace App\Repositories;

use App\Models\WellMaster;
use App\Repositories\Contracts\IWellMasterRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class WellMasterRepository implements IWellMasterRepository
{
    public static array $searchableCols = ['field_name' ,'ids_wellname' ,'well_number' ,'legal_well' ,'wbs_number', 'rig_no'];
    private ?Builder $builder;
    private array $params;

    public function __construct()
    {
        $this->builder = WellMaster::query();

        $this->setParams(null);
    }

    function pagingWellMaster(?int $page = null): LengthAwarePaginator
    {
        return $this->builder->orderBy('well_number')->paginate();
    }
    function pagingSearchWellMaster(string $query): LengthAwarePaginator
    {
        $builder = $this->builder; /*$builder = $builder->whereDate('created_at', '=', Carbon::now()); $builder->orWhere('ids_wellname', 'ILIKE', '%peTan%');*/

        $this->setParams($query);
        foreach ($this->params as $key => $value) {
            $builder->orWhereLike($key, "%$query%");
        }
        return $builder->paginate();
    }
    public function delete(string $id): bool
    {
        $wellMaster = $this->builder->find($id);
        $isNotExists = $wellMaster->get()->isEmpty();
        if ($isNotExists) return false;

        return $wellMaster->delete();
    }

    function getWellMasters(int $limit): Collection
    {
        return $this->builder
            ->orderBy('ids_well_name')
            ->limit($limit)
            ->get();
    }

    function getWellMastersByQuery(string $query, ?int $limit = 7): Collection
    {
        $this->setParams($query);
        $builder = $this->builder;

        foreach ($this->params as $key => $value) {
            $builder->orWhereLike($key, "%$query%");
        }
        return $builder->orderByDesc('created_at')->limit($limit)->get();
    }

    private function setParams($query): void
    {
        $params = [];
        foreach (self::$searchableCols as $column) {$params[$column] = $query;}

        $this->params = $params;
    }
}
