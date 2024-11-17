<?php

namespace Database\Seeders;

use App\Models\Operator;
use App\Models\Vehicle;
use App\Models\VehicleClass;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opeIds = Operator::query()->get()
            ->map(fn(Operator $operator) => $operator->id)->toArray();

        $vehClassIds = VehicleClass::query()->get()
            ->map(fn(VehicleClass $class) => $class->id)->toArray();

        /*foreach ($opeIds as $opeId) {
            $randOpeId = $opeIds[rand(0, count($opeIds) - 1)];
            Vehicle::factory()->create(['operator_id' => $randOpeId]);
        }*/
        $randOpeId = $opeIds[rand(0, count($opeIds) - 1)];
        $randVehId = $vehClassIds[rand(0, count($vehClassIds) - 1)];
        $attr = [
            'operator_id' => $randOpeId,
            'vehicle_class_id' => $randVehId
        ];
        Vehicle::factory(25)->create($attr);
    }
}
