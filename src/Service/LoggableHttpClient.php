<?php
declare(strict_types=1);

namespace App\Service;

use App\Event\HttpRequestExecutedEvent;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

#[AsDecorator('http_client')]
class LoggableHttpClient implements HttpClientInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $this->eventDispatcher->dispatch(new HttpRequestExecutedEvent());
        return $this->httpClient->request($method, $url, $options);
    }

    public function stream(iterable|ResponseInterface $responses, float $timeout = null): ResponseStreamInterface
    {
        return $this->httpClient->stream($responses, $timeout);
    }

    public function withOptions(array $options): static
    {
        $this->httpClient->withOptions($options);

        return $this;
    }
}