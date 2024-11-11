<?php

namespace Database\Seeders;

use App\Models\Crew;
use App\Models\Operator;
use Illuminate\Database\Seeder;

class CrewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opeIds = Operator::query()->get()
            ->map(fn(Operator $operator) => $operator->id)->toArray();

        /*foreach ($opeIds as $opeId) {
            $randOpeId = $opeIds[rand(0, count($opeIds) - 1)];
            Crew::factory()->create(['operator_id' => $randOpeId]);
        }*/
        $randOpeId = $opeIds[rand(0, count($opeIds) - 1)];
        Crew::factory(25)->create(['operator_id' => $randOpeId]);
    }
}
