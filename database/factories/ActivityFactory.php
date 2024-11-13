<?php

namespace Database\Factories;

use App\Utils\ActNameEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ActNameEnum::Incoming->value,
            'process' => $this->faker->time,
        ];
    }
}
