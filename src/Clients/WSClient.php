<?php

namespace Albocode\CcatphpSdk\Clients;

use Phrity\Net\Uri;

class WSClient
{

    private \WebSocket\Client $wsClient;

    public function __construct(string $host, ?int $port = null, string $apikey = '')
    {
        //todo add support to wss
        $wsUri = (new Uri())
            ->withScheme('ws')
            ->withHost($host)
            ->withPath('ws')
            ->withPort($port)
        ;
        $this->wsClient = new \WebSocket\Client($wsUri, ['filter' => ['text']]);
    }

    /**
     * @return \WebSocket\Client
     */
    public function getWsClient(): \WebSocket\Client
    {
        return $this->wsClient;
    }


}