<?php

namespace App\EventSubscriber;

use \App\Event\NewMovieCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;

class NotifyOnNewMovieSubscriber implements EventSubscriberInterface
{
//    public function __construct(
//        private MailerInterface $mailer,
//    )
//    {
//    }

    public function onNewMovieCreatedEvent(NewMovieCreatedEvent $event): void
    {
        $movie = $event->movie;
        $this->mailer->send(
            'marketing@ma_boite.fr',
            'New movie "'.$movie->getName().'"',
            'Please ensure that this is Safe For Work.'
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NewMovieCreatedEvent::class => 'onNewMovieCreatedEvent',
        ];
    }
}
