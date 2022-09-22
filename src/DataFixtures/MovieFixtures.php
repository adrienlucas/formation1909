<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
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
        $this->addReference('movie_matrix', $movie);

        $movie = new Movie();
        $movie->setName('Jurassic Park');
        $movie->setDescription('Dinosaurs, Dinosaurs everywhere');
        $movie->setYear(1993);
        $movie->setGenre($genreAction);
        $manager->persist($movie);
        $this->addReference('movie_jurassic', $movie);

        $movie = new Movie();
        $movie->setName('Black Panther');
        $movie->setDescription('Another superhero');
        $movie->setYear(2018);
        $movie->setGenre($genreSuperHeroes);
        $manager->persist($movie);

        $movie = new Movie();
        $movie->setName('The Matrix Revolutions');
        $movie->setYear(2003);
        $manager->persist($movie);

        $movie = new Movie();
        $movie->setName('Avatar');
        $movie->setYear(2009);
        $manager->persist($movie);

        $manager->flush();
    }
}
