<?php

namespace Database\Factories;

use App\Utils\ManPowerRoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Crew>
 */
class CrewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'role' => ManPowerRoleEnum::ASSOCIATE_DRIVER_ROLE->value,
            'company_id' => null
        ];
    }
}
