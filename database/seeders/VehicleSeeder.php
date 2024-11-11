<?php

namespace Database\Seeders;

use App\Models\Operator;
use App\Models\Vehicle;
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

        /*foreach ($opeIds as $opeId) {
            $randOpeId = $opeIds[rand(0, count($opeIds) - 1)];
            Vehicle::factory()->create(['operator_id' => $randOpeId]);
        }*/
        $randOpeId = $opeIds[rand(0, count($opeIds) - 1)];
        Vehicle::factory(25)->create(['operator_id' => $randOpeId]);
    }
}
