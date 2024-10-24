<?php

namespace Albocode\CcatphpSdk\Tests\Mocks;

use Albocode\CcatphpSdk\Clients\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class TestHttpClient extends HttpClient
{
    private Client $mockClient;

    public function __construct(
        Client $mockClient,
        string $host = 'example.com',
        ?int $port = null,
        ?string $apikey = null,
        ?bool $isHTTPs = false
    ) {
        $this->mockClient = $mockClient;
        parent::__construct($host, $port, $apikey, $isHTTPs);
    }

    protected function createHttpClient(HandlerStack $handlerStack): Client
    {
        return $this->mockClient;
    }
}