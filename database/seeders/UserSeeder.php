<?php

namespace Database\Seeders;

use App\Models\Company;
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
        Company::query()->each(function (Company $operator) {

            User::factory()->create(['company_id' => $operator->id]);
        });
        $email = 'mk.planner@pertamina.com';
        User::factory()->create([
            'name' => 'Planner EFO',
            'email' => $email,
            'username' => explode('@', $email)[0],
            'role' => UserRoleEnum::DEV_ROLE->value,
            'company_id' => Company::query()->first()->id,
        ]);
    }
}
