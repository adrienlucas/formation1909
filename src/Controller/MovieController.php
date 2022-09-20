<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movie/list', name: 'app_movie_list')]
    public function list(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render('movie/list.html.twig', [
            'movies' => $movies
        ]);
    }

    #[Route('/movie/{id}', name: 'app_movie_show', requirements: ['id' => '\d+'])]
    public function show(Movie $movie): Response
    {
        return $this->render('movie/index.html.twig', [
            'movie' => $movie
        ]);
    }

    #[Route('/movie/create', name: 'app_movie_create')]
    public function create(): Response
    {
        $form = $this->createForm(MovieType::class);

        return $this->render('movie/create.html.twig', [
            'creationForm' => $form->createView(),
        ]);
    }
}
