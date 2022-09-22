<?php

namespace App\Tests;

use App\DataFixtures\MovieFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{
    private ReferenceRepository $fixtures;

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
        $this->fixtures = $fixtureExecutor->getReferenceRepository();

        $fixtureExecutor->execute([new MovieFixtures()]);

        self::ensureKernelShutdown();
    }

    public function testItShowsAMovie(): void
    {
        $client = static::createClient();
        $idJurassicMovie = $this->fixtures->getReference('movie_jurassic')
            ->getId();
        $client->request('GET', '/movie/'.$idJurassicMovie);

        $responseContent = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Juraseeesic Park', $responseContent);
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