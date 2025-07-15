<?php

namespace App\Tests\Integration\Database;

use App\Tests\Integration\Fixtures\Database as DB;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[TestDox('Tests Database objects')]
class ProcTest extends TestCase
{
    #[TestDox('It has a proc called sleep_and_return which idles for n seconds before returning its parameter value')]
    public function testSleepAndReturnProc()
    {
        $sleepDuration = 2;

        $connection = DB::getDbalConnection();
        $startTime = microtime(true);
        $result = $connection->executeQuery('CALL sleep_and_return(?)', [$sleepDuration]);
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        $this->assertEquals($sleepDuration, $result->fetchOne());
        $this->assertGreaterThanOrEqual($sleepDuration, $executionTime);
    }
}
