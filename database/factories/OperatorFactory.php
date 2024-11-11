<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OperatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prefix' => null,
            'postfix' => null,
            'name' => fake()->name,
            'short_name' => fake()->name,
            'department_id' => null
        ];
    }
    public function createWithId()
    {
        $instance = $this->create();
        return $instance->id;
    }
}
