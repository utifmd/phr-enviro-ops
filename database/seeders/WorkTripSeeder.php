<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\WorkTrip;
use App\Models\Area;
use App\Utils\ActNameEnum;
use App\Utils\AreaNameEnum;
use App\Utils\WorkTripTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class WorkTripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // WorkTrip::query()->truncate();

        /*$data = [
            'type' => WorkTripTypeEnum::ACTUAL->value,
            'act_name' => ActNameEnum::Incoming->value,
            'act_process' => "Mud Pit Closure",
            'act_unit' => "Load",
            'act_value' => 24,
            'area_name' => AreaNameEnum::MINAS->value,
            'area_loc' => "CMTF-MINAS",
            'date' => date("Y-m-d"),
            'time' => date("H:i:s"),
            'post_id' => '735b4915-04f7-4fc8-8edf-acf7896043b5', //rand(0, count($postIds) - 1)
        ];
        WorkTrip::query()->create($data);*/

        /*$postIds = [
            'da10586e-a2cd-4457-a50f-dd48073e4881',
        ];
        $areas = Area::query()
            ->where('name', '=', AreaNameEnum::MINAS->value)
            ->get();
        $acts = Activity::all();

        for ($i = 0; $i < 203; $i++) {
            $actIdx = rand(0, count($acts) - 1);
            $areaIdx = rand(0, count($areas) - 1);
            $data = [
                'type' => WorkTripTypeEnum::cases()[rand(0, 1)]->value,
                'act_name' => $acts[$actIdx]['name'],
                'act_process' => $acts[$actIdx]['process'],
                'act_unit' => $acts[$actIdx]['unit'],
                'area_name' => $areas[$areaIdx]['name'],
                'area_loc' => $areas[$areaIdx]['location'],
                'post_id' => $postIds[0], //rand(0, count($postIds) - 1)
            ];
            WorkTrip::factory()->create($data);
        }
        */
    }
}
