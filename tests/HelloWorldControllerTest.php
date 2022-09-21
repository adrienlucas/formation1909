<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloWorldControllerTest extends WebTestCase
{
    public function testItSaysHelloByDefault(): void
    {
        $client = static::createClient();
        $client->request('GET', '/hello');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Hello Le Monde !');
//        $this->assertStringContainsString('Hello Le Monde !', $client->getResponse()->getContent());
    }

    public function testItSaysHelloToSomeone(): void
    {
        $client = static::createClient();
        $client->request('GET', '/hello/Adrien');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Hello Adrien !');
    }
}
