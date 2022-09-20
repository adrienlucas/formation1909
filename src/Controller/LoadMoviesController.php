<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoadMoviesController extends AbstractController
{
    #[Route('/load/movies', name: 'app_load_movies')]
    public function index(MovieRepository $movieRepository, GenreRepository $genreRepository): Response
    {
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

        return new Response('OK');
    }
}
