<?php

namespace App\Tests\Functional\System;

use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

#[TestDox('Tests of Symfony testing')]
class SymfonyTest extends WebTestCase
{
    #[TestDox('It serves the home page')]
    public function testSymfonyWelcomeScreenDisplays()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('body', 'Hello world');
    }
}
