<?php

namespace Database\Factories;

use App\Utils\CrewRoleEnum;
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
            'role' => CrewRoleEnum::ASSOCIATE_DRIVER_ROLE->value,
            'operator_id' => null
        ];
    }
}
