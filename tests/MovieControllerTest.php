<?php

namespace App\Tests;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{
    public function setup(): void
    {
        $kernel = self::bootKernel();

        $entityManager = self::getContainer()->get(EntityManagerInterface::class);

        $genreRepository = $entityManager->getRepository(Genre::class);
        $movieRepository = $entityManager->getRepository(Movie::class);
//        $genreRepository = $kernel->getContainer()->get(GenreRepository::class);
//        $movieRepository = $kernel->getContainer()->get(MovieRepository::class);

        $genreAction = new Genre();
        $genreAction->setName('Action');
        $genreRepository->add($genreAction);

        $genreSuperHeroes = new Genre();
        $genreSuperHeroes->setName('Super Heroes');
        $genreRepository->add($genreSuperHeroes);

        $movie = new Movie();
        $movie->setName('The Matrix');
        $movie->setDescription('Neo takes red pill');
        $movie->setYear(1999);
        $movie->setGenre($genreAction);
        $movieRepository->add($movie);

        $movie = new Movie();
        $movie->setName('Jurassic Park');
        $movie->setDescription('Dinosaurs, Dinosaurs everywhere');
        $movie->setYear(1993);
        $movie->setGenre($genreAction);
        $movieRepository->add($movie);

        $movie = new Movie();
        $movie->setName('Black Panther');
        $movie->setDescription('Another superhero');
        $movie->setYear(2018);
        $movie->setGenre($genreSuperHeroes);
        $movieRepository->add($movie, true);

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