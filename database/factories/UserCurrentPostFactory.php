<?php

namespace Database\Factories;

use App\Models\Information;
use App\Models\PlanOrder;
use App\Models\Post;
use App\Models\PlanTrip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserCurrentPost>
 */
class UserCurrentPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $steps = Post::ROUTE_POS . ';' . Information::ROUTE_POS;
        return [
            'steps' => $steps,
            'step_at' => Information::ROUTE_POS,
            'url' => Information::ROUTE_NAME . '.create'
        ];
    }
}
