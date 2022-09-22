<?php

namespace App\EventSubscriber;

use \App\Event\HttpRequestExecutedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CountHttpRequestsSubscriber implements EventSubscriberInterface
{
    public function onHttpRequestExecutedEvent(HttpRequestExecutedEvent $event): void
    {
        $counter = '/tmp/adrien.count';
        if(file_exists($counter)) {
            $count = file_get_contents($counter);
        } else {
            $count = 0;
        }

        file_put_contents($counter, $count+1);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            HttpRequestExecutedEvent::class => 'onHttpRequestExecutedEvent',
        ];
    }
}
