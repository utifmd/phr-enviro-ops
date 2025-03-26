<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Utils\EquipmentEnum;
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
            Equipment::factory()->create([
                'name' => EquipmentEnum::HEAVY_VEHICLE_TYPE->value,
                'type' => $type,
            ]);
        }
    }
}
