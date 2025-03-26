<?php

namespace Tests\Models;

use App\Models\PostFacReport;
use App\Utils\PostFacReportTypeEnum;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class WorkTripTest extends TestCase
{
    public function testName()
    {
        $collections = \App\Utils\PostFacReportTypeEnum::cases()[0];
        Log::debug(json_encode($collections));

        self::assertTrue(true);
        /*foreach ($collections as $i => $collection) {
            self::assertSame(WorkTripTypeEnum::cases()[$i], $collection);
        }*/
    }
}
