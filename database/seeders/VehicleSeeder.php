<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Vehicle;
use App\Models\Equipment;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opeIds = Company::query()->get()
            ->map(fn(Company $operator) => $operator->id)->toArray();

        $vehClassIds = Equipment::query()->get()
            ->map(fn(Equipment $class) => $class->id)->toArray();

        /*foreach ($opeIds as $opeId) {
            $randOpeId = $opeIds[rand(0, count($opeIds) - 1)];
            Vehicle::factory()->create(['company_id' => $randOpeId]);
        }*/
        $randOpeId = $opeIds[rand(0, count($opeIds) - 1)];
        $randVehId = $vehClassIds[rand(0, count($vehClassIds) - 1)];
        $attr = [
            'company_id' => $randOpeId,
            'vehicle_class_id' => $randVehId
        ];
        Vehicle::factory(25)->create($attr);
    }
}
