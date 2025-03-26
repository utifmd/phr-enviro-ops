<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Company;
use Illuminate\Database\Seeder;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collection = Team::query()->get()->all();
        foreach ($collection as $departmentId) {
            Company::factory()->create(['department_id' => $departmentId->id]);
        }
    }
}
