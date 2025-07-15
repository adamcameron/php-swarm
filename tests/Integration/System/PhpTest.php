<?php

namespace App\Tests\Integration\System;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[TestDox('Tests of the PHP installation')]
class PhpTest extends TestCase
{
    #[TestDox('It has the expected PHP version')]
    public function testPhpVersion()
    {
        $expectedPhpVersion = '8.4';
        $actualPhpVersion = phpversion();
        $this->assertStringStartsWith(
            $expectedPhpVersion,
            $actualPhpVersion,
            "Expected PHP version to start with $expectedPhpVersion, but got $actualPhpVersion"
        );
    }
}
