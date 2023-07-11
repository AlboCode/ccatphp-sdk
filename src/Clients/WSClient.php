<?php

namespace Albocode\CcatphpSdk\Clients;

use Phrity\Net\Uri;
use WebSocket\Client;

class WSClient
{

    private Client $wsClient;

    public function __construct(string $host, ?int $port = null, string $apikey = '')
    {
        //todo add support to wss
        $wsUri = (new Uri())
            ->withScheme('ws')
            ->withHost($host)
            ->withPath('ws')
            ->withPort($port)
        ;
        $this->wsClient = new Client($wsUri, ['filter' => ['text']]);
    }

    /**
     * @return Client
     */
    public function getWsClient(): Client
    {
        return $this->wsClient;
    }


}