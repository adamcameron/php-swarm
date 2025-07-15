<?php

namespace App\Tests\Unit;

use App\Greeter;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[TestDox('Tests of the Greeter class')]
class GreeterTest extends TestCase
{
    #[TestDox('It greets formally by default')]
    public function testFormalGreeting()
    {
        $name = 'Zachary';
        $expectedGreeting = "Hello, $name";
        $actualGreeting = Greeter::greet($name);
        $this->assertEquals(
            $expectedGreeting,
            $actualGreeting,
            "Expected greeting to be $expectedGreeting, but got $actualGreeting"
        );
    }

    #[TestDox('It greets informally')]
    public function testInformalGreeting()
    {
        $name = 'Zachary';
        $expectedGreeting = "Hi, $name";
        $actualGreeting = Greeter::greet($name, Greeter::INFORMAL);
        $this->assertEquals(
            $expectedGreeting,
            $actualGreeting,
            "Expected greeting to be $expectedGreeting, but got $actualGreeting"
        );
    }
}
