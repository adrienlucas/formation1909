<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movie', name: 'app_movie')]
    public function list(): Response
    {
        return new Response();
    }

    #[Route('/movie/{id}', name: 'app_movie')]
    public function show(int $id): Response
    {
        $movies = [
        ];

        if(!array_key_exists($id, $movies)) {
            throw $this->createNotFoundException('Movie not found!');
        }

        $movie = $movies[$id];

        return $this->render('movie/index.html.twig', [
            'movie' => $movie
        ]);
    }
}
