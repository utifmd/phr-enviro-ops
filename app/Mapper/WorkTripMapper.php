<?php

namespace App\Mapper;

use App\Mapper\Contracts\IWorkTripMapper;
use App\Utils\WorkTripStatusEnum;
use App\Utils\WorkTripTypeEnum;
use Illuminate\Support\Collection;

class WorkTripMapper implements IWorkTripMapper
{

    public function mapTripPairActualValue(array $tripState): array
    {
        $actualTrips = [];
        $planTrips = [];
        // usort($tripState, fn($a, $b) => $b['id'] > $a['id']);
        foreach ($tripState as $trip) {
            if($trip['type'] != WorkTripTypeEnum::PLAN->value) continue;
            $planTrips[] = $trip;
        }
        foreach ($tripState as $i => $trip) {
            if($trip['type'] != WorkTripTypeEnum::ACTUAL->value) continue;
            $trip['act_value'] = ($trip['act_value'] ?? 0).'/'.($planTrips[$i]['act_value'] ?? 0);
            $actualTrips[] = $trip;
        }
        return $actualTrips;
    }

    public function mapPairInfoAndTripActualValue(array $infos, array $tripState): array
    {
        $actualTrips = [];
        foreach ($tripState as $trip) {
            if($trip['type'] != WorkTripTypeEnum::ACTUAL->value) continue;
            // $trip['act_value'] = ($trip['act_value'] ?? 0).'/'.($planTrips[$i]['act_value'] ?? 0);
            $trip['act_value'] = ($trip['act_value'] ?? 0).'/';

            foreach ($infos as $info) {
                if ($trip['act_name'] == $info['act_name'] &&
                    $trip['act_process'] == $info['act_process'] &&
                    $trip['act_unit'] == $info['act_unit'] &&
                    $trip['area_loc'] == $info['area_loc']) {
                    $trip['act_value'] .= $info['act_value'];
                }
            }
            $actualTrips[] = $trip;
        }
        return $actualTrips;
    }

    public function mapTripUnpairActualValue(array $tripState): array
    {
        $trips = [];
        foreach ($tripState as $trip) {
            $trip['status'] = WorkTripStatusEnum::PENDING->value;
            $trip['act_value'] = explode('/', $trip['act_value'])[0] ?? 0;
            $trips[] = $trip;
        }
        return $trips;
    }

    function mapToOptions(Collection $collection): Collection
    {
        return $collection->map(function ($model) {
            if (isset($model->name)) {
                $model->name = trim($model->prefix.' '.$model->name.' '.$model->postfix);
            } else {
                $model->name = $model->plat;
            }
            $model->value = $model->id;
            return $model;
        });
    }
}
