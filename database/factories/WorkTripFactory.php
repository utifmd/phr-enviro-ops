<?php

namespace Database\Factories;

use App\Utils\ActNameEnum;
use App\Utils\AreaNameEnum;
use App\Utils\WorkTripTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkTrip>
 */
class WorkTripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => WorkTripTypeEnum::PLAN->value,
            'date' => fake()->date,
            'time' => fake()->time,
            'act_name' => ActNameEnum::Incoming->value,
            'act_process' => null,
            'act_unit' => null,
            'act_value' => fake()->numberBetween(1, 42),
            'area_name' => AreaNameEnum::MINAS->value,
            'area_loc' => null,
            'post_id' => null
        ];
    }
}
