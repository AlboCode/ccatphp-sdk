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
        ?bool $isHTTPs = false,
    ) {
        $this->mockClient = $mockClient;
        parent::__construct($host, $port, $apikey, $isHTTPs);
    }

    public function createHttpClient(?HandlerStack $handlerStack = null): Client
    {
        return $this->mockClient;
    }
}