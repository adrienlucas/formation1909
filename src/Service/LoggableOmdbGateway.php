<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Movie;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsDecorator(OmdbGateway::class)]
class LoggableOmdbGateway extends OmdbGateway
{
    public function __construct(
        private LoggerInterface $logger,
        private OmdbGateway $gateway,
    )
    {
    }

    public function getPosterByMovie(Movie $movie): ?string
    {
        $this->logger->log('notice', 'OMDB was requested');
        return $this->gateway->getPosterByMovie($movie);
    }
}