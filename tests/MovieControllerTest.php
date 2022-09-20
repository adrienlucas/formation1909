<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{
    public function testItShowsAMovie(): void
    {
        $client = static::createClient();
        $client->request('GET', '/movie/1');

        $responseContent = $client->getResponse()->getContent();

        $this->assertContains('toto', ['tata', 'titi', 'toto']);

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Jurassic Park', $responseContent);
        $this->assertStringContainsString('Dinosaurs, Dinosaurs everywhere', $responseContent);
        $this->assertStringContainsString('1993', $responseContent);
    }

    public function testItShowsAnErrorWhenMovieNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/movie/123');

        $this->assertResponseStatusCodeSame(404);
    }
}

// adrien.lucas@sensiolabs.com