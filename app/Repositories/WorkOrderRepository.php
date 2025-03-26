<?php

namespace App\Repositories;

use App\Models\PostWo;
use App\Repositories\Contracts\IWorkOrderRepository;
use App\Utils\PostWoScopeEnum;
use App\Utils\PostWoStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkOrderRepository implements IWorkOrderRepository
{
    function addWorkOrder(array $request): ?PostWo
    {
        $createdPost = PostWo::query()->create($request);
        $post = $this->fromBuilderOrModel($createdPost);

        if (is_null($post->id)) return null;
        return $post;
    }

    function getWorkOrderByPostId(string $id): Collection
    {
        $builder = PostWo::query()->where(
            'post_id', '=', $id
        );
        return $builder->get();
    }

    public function getWorkOrdersLoadBy(
        string $year, string $month, string $idsWellName, bool $isRig = false): Collection
    {
        $whereBindings = [
            $year, $month, $isRig, $idsWellName,
            PostWoStatusEnum::STATUS_ACCEPTED->value
        ];
        $selectQuery = 'ids_wellname, is_rig,
                 DATE_PART(\'day\', created_at) AS day,
                 COUNT(created_at) AS count';

        $whereQuery = "DATE_PART('year', created_at) = ? AND
                DATE_PART('month', created_at) = ? AND
                is_rig = ? AND
                ids_wellname = ? AND
                status = ? ";

        $groupByQuery = 'DATE_PART(\'day\', created_at),
                 ids_wellname, is_rig';

        return PostWo::query()->selectRaw($selectQuery)
            ->whereRaw($whereQuery, $whereBindings)
            ->groupByRaw($groupByQuery)
            ->get();
    }
    public function getWorkOrdersNameByMonth(string $year, string $month): Collection
    {
        $builder = PostWo::query()
            ->select([
                'work_orders.ids_wellname', 'work_orders.is_rig', 'well_masters.wbs_number'])
            ->leftJoin('well_masters',
                'well_masters.ids_wellname', '=', 'work_orders.ids_wellname')
            ->whereRaw(
                "DATE_PART('year', work_orders.created_at) = ? AND
                DATE_PART('month', work_orders.created_at) = ? AND
                work_orders.status = ? ", [$year, $month, PostWoStatusEnum::STATUS_ACCEPTED->value])
            ->groupByRaw(
                'DATE_PART(\'month\', work_orders.created_at),
                work_orders.ids_wellname,
                well_masters.wbs_number,
                work_orders.is_rig');

        return $builder->get();
    }

    function searchWorkOrderByWell(
        string $wellNumber, ?string $wbsNumber, ?string $createdDate, ?string $createdTime): Collection
    {
        $builder = PostWo::query();
        $builder
            ->where('well_number', 'LIKE', '%'. $wellNumber .'%')
            ->orWhere('wbs_number', 'LIKE', '%'. $wellNumber .'%');

        if (!is_null($createdDate)) {
            $builder->whereDate('created_at', '=', $createdDate); // $builder->whereDate('created_at', Carbon::today());
        }
        if (!is_null($createdTime)) {
            $builder->whereTime('created_at', '=', $createdTime);
        }
        return $builder->get();
    }

    function updateWorkOrder(string $workOrderId, array $request): ?PostWo
    {
        try {
            $model = PostWo::query()->find($workOrderId);
            if(isset($request['shift']))
                $model->shift = $request['shift'];
            if(isset($request['is_rig']))
                $model->is_rig = $request['is_rig'];
            if(isset($request['status']))
                $model->status = $request['status'];

            if(!$model->save()) return null;
            return $model
                ->get()
                ->first();

        } catch (\Throwable $t){
            Log::error($t->getMessage());
            return null;
        }
    }

    function removeWorkOrder(string $workOrderId): bool
    {
        try {
            $model = PostWo::query()->find($workOrderId);
            return $model->delete();
        } catch (\Throwable $t) {
            Log::error($t->getMessage());
            return false;
        }
    }

    public function removeWorkOrderBy(string $postId): bool
    {
        $builder = PostWo::query()
            ->where('post_id', '=', $postId);

        return $builder->delete();
    }

    private function fromBuilderOrModel(Model|Builder $model): PostWo
    {
        $workOrder = new PostWo();
        $workOrder->id = $model['id'];
        $workOrder->shift = $model['shift'];
        $workOrder->is_rig = $model['is_rig'];
        $workOrder->status = $model['status'];
        $workOrder->ids_wellname = $model['ids_wellname'];
        $workOrder->post_id = $model['post_id'];
        $workOrder->created_at = $model['created_at'];
        $workOrder->updated_at = $model['updated_at'];
        return $workOrder;
    }

    function getWorkOrdersByDepartmentId(string $id): Collection
    {
        return PostWo::query()->where('department_id', '=', $id)->get();
    }

    function getWorkOrdersByOperatorId(string $id): Collection
    {
        return PostWo::query()->where('company_id', '=', $id)->get();
    }

    public function getWorkOrdersByVehicleId(string $id): Collection
    {
        return PostWo::query()->where('vehicle_id', '=', $id)->get();
    }

    public function countWorkOrdersByScope(int $scope): Collection
    {
        $builder = PostWo::query();

        $builder = match ($scope) {
            PostWoScopeEnum::DEP_SCOPE->value => $builder
                ->selectRaw('teams.short_name AS scope_name, COUNT(work_orders.department_id) AS count')
                ->join('teams', 'teams.id', '=', 'work_orders.department_id')
                ->groupBy('work_orders.department_id', 'teams.short_name'),

            PostWoScopeEnum::OPE_SCOPE->value => $builder
                // ->selectRaw('operators.short_name AS scope_name, COUNT(work_orders.company_id) AS count')
                ->selectRaw('TRIM(CONCAT(operators.prefix, \' \', operators.short_name, \' \', operators.postfix)) AS scope_name, COUNT(work_orders.company_id) AS count')
                ->join('operators', 'operators.id', '=', 'work_orders.company_id')
                ->groupBy('work_orders.company_id', 'operators.short_name', 'operators.prefix', 'operators.postfix'),

            PostWoScopeEnum::VEH_SCOPE->value => $builder
                ->selectRaw('vehicles.plat AS scope_name, COUNT(work_orders.vehicle_id) AS count')
                ->join('vehicles', 'vehicles.id', '=', 'work_orders.vehicle_id')
                ->groupBy('work_orders.vehicle_id', 'vehicles.plat'),

            default => $builder
        };
        return $builder->get();
    }
}
