<?php

namespace Database\Factories;

use App\Utils\Constants;
use App\Utils\PostTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'id' => fake()->name(),
            'title' => Constants::EMPTY_STRING, //fake()->title(),
            'description' => Constants::EMPTY_STRING, // fake()->text(),
            'type' => PostTypeEnum::POST_WO_TYPE->value
        ];
    }
}
