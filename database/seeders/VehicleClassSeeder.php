<?php

namespace Database\Seeders;

use App\Models\VehicleClass;
use App\Utils\VehicleClassEnum;
use Illuminate\Database\Seeder;

class VehicleClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeAllowed = ['Vacuum Truck', 'Water Truck'];

        foreach ($typeAllowed as $type) {
            VehicleClass::factory()->create([
                'name' => VehicleClassEnum::HEAVY_VEHICLE_TYPE->value,
                'type' => $type,
            ]);
        }
    }
}
