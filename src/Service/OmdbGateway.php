<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Movie;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbGateway
{
    public function __construct(
        private HttpClientInterface $httpClient,
    ) {}

    public function getPosterByMovie(Movie $movie): ?string
    {
        $response = $this->httpClient->request('GET', sprintf(
            'https://www.omdbapi.com/?apikey=%s&t=%s',
            'e0ded5e2',
            $movie->getName()
        ));

        $movieData = $response->toArray();

        return array_key_exists('Poster', $movieData) ? $movieData['Poster'] : null;
    }
}