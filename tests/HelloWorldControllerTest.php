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
        $this->assertSame('Hello Le Monde !', $client->getResponse()->getContent());
    }

    public function testItSaysHelloToSomeone(): void
    {
        $client = static::createClient();
        $client->request('GET', '/hello/Adrien');

        $this->assertResponseIsSuccessful();
        $this->assertSame('Hello Adrien !', $client->getResponse()->getContent());
    }
}
