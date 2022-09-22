<?php
declare(strict_types=1);

namespace App\Event;

use App\Entity\Movie;
use Symfony\Contracts\EventDispatcher\Event;

class NewMovieCreatedEvent extends Event
{
    public function __construct(
        public Movie $movie,
    )
    {
    }
}