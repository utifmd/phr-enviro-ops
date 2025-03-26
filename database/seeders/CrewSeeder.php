<?php

namespace Database\Seeders;

use App\Models\ManPower;
use App\Models\Company;
use Illuminate\Database\Seeder;

class CrewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opeIds = Company::query()->get()
            ->map(fn(Company $operator) => $operator->id)->toArray();

        /*foreach ($opeIds as $opeId) {
            $randOpeId = $opeIds[rand(0, count($opeIds) - 1)];
            Crew::factory()->create(['company_id' => $randOpeId]);
        }*/
        $randOpeId = $opeIds[rand(0, count($opeIds) - 1)];
        ManPower::factory(25)->create(['company_id' => $randOpeId]);
    }
}
