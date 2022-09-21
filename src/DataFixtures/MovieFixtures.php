<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genreAction = new Genre();
        $genreAction->setName('Action');
        $manager->persist($genreAction);

        $genreSuperHeroes = new Genre();
        $genreSuperHeroes->setName('Super Heroes');
        $manager->persist($genreSuperHeroes);

        $movie = new Movie();
        $movie->setName('The Matrix');
        $movie->setDescription('Neo takes red pill');
        $movie->setYear(1999);
        $movie->setGenre($genreAction);
        $manager->persist($movie);

        $movie = new Movie();
        $movie->setName('Jurassic Park');
        $movie->setDescription('Dinosaurs, Dinosaurs everywhere');
        $movie->setYear(1993);
        $movie->setGenre($genreAction);
        $manager->persist($movie);

        $movie = new Movie();
        $movie->setName('Black Panther');
        $movie->setDescription('Another superhero');
        $movie->setYear(2018);
        $movie->setGenre($genreSuperHeroes);
        $manager->persist($movie);

        $manager->flush();
    }
}
