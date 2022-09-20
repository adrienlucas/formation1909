<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    #[Route('/hello/{name}', name: 'app_hello_world', requirements: ['name' => '[a-zA-Z]+'])]
    public function index(Request $request, string $name = 'Le Monde'): Response
    {
        return $this->render('hello_world/index.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/users/{id}', name: 'app_hello_user', requirements: ['id' => '\d+'])]
    public function showUser(int $id): Response
    {
        return new Response('This is the user '.$id);
    }

    #[Route('/users/list', name: 'app_hello_users')]
    public function listUsers(): Response
    {
        return new Response('This is all the users.');
    }

}
