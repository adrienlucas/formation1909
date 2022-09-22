<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use App\Service\OmdbGateway;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MovieController extends AbstractController
{
    public function __construct(
        private OmdbGateway $omdbGateway,
    ) {}

    #[Route('/movie/list', name: 'app_movie_list')]
    public function list(Request $request, MovieRepository $movieRepository): Response
    {
        $limit = $request->query->get('limit', 20);

        if($limit > 100) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }

        $movies = $movieRepository->findAll($limit);

        return $this->render('movie/list.html.twig', [
            'movies' => $movies
        ]);
    }

    #[Route('/movie/{id}', name: 'app_movie_show', requirements: ['id' => '\d+'])]
    public function show(Movie $movie): Response
    {
        $poster = $this->omdbGateway->getPosterByMovie($movie) ?? 'https://www.vector-eps.com/wp-content/gallery/movie-photo-tape-images/thumbs/thumbs_movie-photo-tape-image3.jpg';

        return $this->render('movie/index.html.twig', [
            'movie' => $movie,
            'poster' => $poster,
        ]);
    }

    #[Route('/movie/create', name: 'app_movie_create')]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request, MovieRepository $movieRepository): Response
    {
        $form = $this->createForm(MovieType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var Movie $movie */
            $movie = $form->getData();
            $movie->setCreatedBy($this->getUser());

            $movieRepository->add($movie, true);

            $this->addFlash('success', 'The movie "'.$movie->getName().'" has been created.');

            return $this->redirectToRoute('app_movie_list');
        }

        return $this->render('movie/create.html.twig', [
            'creationForm' => $form->createView(),
        ]);
    }

    #[Route('/movie/delete/{id}', name: "app_movie_delete")]
    public function deleteMovie(Movie $movie, MovieRepository $movieRepository): Response
    {
        $movieRepository->remove($movie, true);

        return $this->redirectToRoute('app_movie_list');
    }
}
