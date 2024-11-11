<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Operator;
use Illuminate\Database\Seeder;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collection = Department::query()->get()->all();
        foreach ($collection as $departmentId) {
            Operator::factory()->create(['department_id' => $departmentId->id]);
        }
    }
}
