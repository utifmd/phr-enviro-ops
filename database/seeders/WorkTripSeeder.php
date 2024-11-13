<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\WorkTrip;
use App\Models\Area;
use App\Utils\WorkTripTypeEnum;
use Illuminate\Database\Seeder;

class WorkTripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postIds = [
            '5a08a1f7-b30e-4d22-94fb-39d2e1205bdb',
            '6bba2d2a-ed19-4b32-8f77-9e97fc647557',
            '8a13358d-e59a-4138-b94b-d05532bc00ff'
        ];
        $areas = Area::query()->get()->all();
        $acts = Activity::query()->get()->all();

        for ($i = 0; $i < 153; $i++) {
            $actIdx = rand(0, count($acts) - 1);
            $areaIdx = rand(0, count($areas) - 1);
            $data = [
                'type' => WorkTripTypeEnum::cases()[rand(0, 1)]->value,
                'act_name' => $acts[$actIdx]['name'],
                'act_process' => $acts[$actIdx]['process'],
                'act_unit' => $acts[$actIdx]['unit'],
                'area_name' => $areas[$areaIdx]['name'],
                'area_loc' => $areas[$areaIdx]['location'],
                'post_id' => $postIds[rand(0, count($postIds) - 1)],
            ];
            WorkTrip::factory()->create($data);
        }
    }
}
