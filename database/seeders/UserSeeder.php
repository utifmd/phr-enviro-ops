<?php

namespace Database\Seeders;

use App\Models\Operator;
use App\Models\User;
use App\Utils\UserRoleEnum;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Operator::query()->each(function (Operator $operator) {

            User::factory()->create(['operator_id' => $operator->id]);
        });
        $email = 'mk.planner@pertamina.com';
        User::factory()->create([
            'name' => 'Planner EFO',
            'email' => $email,
            'username' => explode('@', $email)[0],
            'role' => UserRoleEnum::DEV_ROLE->value,
            'operator_id' => Operator::query()->first()->id,
        ]);
    }
}
