<?php

namespace Database\Factories;

use App\Utils\EquipmentEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plat' => fake()->name,
            'type' => EquipmentEnum::HEAVY_VEHICLE_TYPE->value,
            'vendor' => fake()->name,
            'vehicle_class_id' => null,
            'company_id' => null
        ];
    }
}
