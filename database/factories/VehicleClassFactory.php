<?php

namespace Database\Factories;

use App\Models\VehicleClass;
use App\Utils\VehicleClassEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehicleClass>
 */
class VehicleClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake(VehicleClassEnum::class),
            'type' => fake()->name,
        ];
    }
}
