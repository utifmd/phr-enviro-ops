<?php

namespace Database\Factories;

use App\Utils\AreaNameEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Area>
 */
class AreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => AreaNameEnum::MINAS->value,
            'location' => fake()->time
        ];
    }
}
