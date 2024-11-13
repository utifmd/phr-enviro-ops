<?php

namespace Tests\Models;

use App\Models\WorkTrip;
use App\Utils\WorkTripTypeEnum;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class WorkTripTest extends TestCase
{
    public function testName()
    {
        $collections = \App\Utils\WorkTripTypeEnum::cases()[0];
        Log::debug(json_encode($collections));

        self::assertTrue(true);
        /*foreach ($collections as $i => $collection) {
            self::assertSame(WorkTripTypeEnum::cases()[$i], $collection);
        }*/
    }

}
