<?php

namespace Albocode\CcatphpSdk\Tests\Mocks;

use Albocode\CcatphpSdk\Clients\WSClient;
use WebSocket\Client;

class TestWsClient extends WSClient
{
    private Client $mockClient;

    public function __construct(
        Client $mockClient,
        string $host = 'example.com',
        ?int $port = null,
        ?string $apikey = null,
        ?bool $isWSS = null,
    ) {
        $this->mockClient = $mockClient;
        parent::__construct($host, $port, $apikey, $isWSS);
    }

    protected function createWsClient(?string $agentId = null, ?string $userId = null): Client
    {
        return $this->mockClient;
    }
}