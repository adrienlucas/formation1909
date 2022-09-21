<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function create(Request $request, MovieRepository $movieRepository): Response
    {
        $form = $this->createForm(MovieType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $movie = $form->getData();
            $movieRepository->add($movie, true);

            $this->addFlash('success', 'The movie "'.$movie->getName().'" has been created.');

            return $this->redirectToRoute('app_movie_list');
        }

        return $this->render('movie/create.html.twig', [
            'creationForm' => $form->createView(),
        ]);
    }
}
