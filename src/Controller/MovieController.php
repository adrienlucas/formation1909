<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
//    #[Route('/movie', name: 'app_movie')]
//    public function index(): Response
//    {
//
//        return new Response();
//    }

    #[Route('/movie/{id}', name: 'app_movie')]
    public function show(int $id): Response
    {
        $movies = [
            ['name' => 'The Matrix', 'description' => 'Neo takes red pill', 'year' => 1999],
            ['name' => 'Jurassic Park', 'description' => 'Dinosaurs, Dinosaurs everywhere', 'year' => 1993],
            ['name' => 'Black Panther', 'description' => 'Another superhero', 'year' => 2018],
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
