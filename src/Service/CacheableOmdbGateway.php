<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Movie;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

//#[AsDecorator(OmdbGateway::class)]
class CacheableOmdbGateway extends OmdbGateway
{
    public function __construct(
        private OmdbGateway $actualOmdbGateway,
        private CacheInterface $cache,
    ) {}

    public function getPosterByMovie(Movie $movie): ?string
    {
        $cacheKey = 'movie_poster_'.md5($movie->getName());

        return $this->cache->get($cacheKey, function(ItemInterface $item) use($movie) {
            $item->expiresAfter(10);
            return $this->actualOmdbGateway->getPosterByMovie($movie);
        });
    }
}