<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prefix' => 'PT',
            'postfix' => 'Tbk',
            'name' => fake()->name,
            'short_name' => fake()->userName
        ];
    }

    public function createWithId()
    {
        $instance = $this->create();
        return $instance->id;
    }
}
