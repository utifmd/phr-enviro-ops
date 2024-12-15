<?php

namespace Database\Factories;

use App\Utils\AreaNameEnum;
use App\Utils\Constants;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event' => Constants::EMPTY_STRING,
            'highlight' => Constants::EMPTY_STRING,
            'is_opened' => false,
            'area' => AreaNameEnum::AllArea->value,
            'route_name' => 'dashboard',
            'url' => 'http://127.0.0.1:8000/logs',
            'user_id' => null,
        ];
    }
}
