<?php

namespace App\Tests;

use App\DataFixtures\MovieFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{
    /**
     * @throws Exception
     */
    public function setup(): void
    {
        self::bootKernel();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = self::getContainer()->get(EntityManagerInterface::class);

        $purger = new ORMPurger($entityManager);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);

        $fixtureExecutor = new ORMExecutor(
            $entityManager,
            $purger
        );

        $fixtureExecutor->execute([new MovieFixtures()]);

        self::ensureKernelShutdown();
    }

    public function testItShowsAMovie(): void
    {
        $client = static::createClient();
        $client->request('GET', '/movie/2');

        $responseContent = $client->getResponse()->getContent();

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