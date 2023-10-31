<?php

namespace Albocode\CcatphpSdk\Clients;

use Phrity\Net\Uri;
use WebSocket\Client;

class WSClient
{

    private string $host;
    private ?int $port;
    private string $apikey;

    public function __construct(string $host, ?int $port = null, string $apikey = '')
    {
        //todo add support to wss

        $this->host = $host;
        $this->port = $port;
        $this->apikey = $apikey;
    }

    /**
     * @return Client
     */
    public function getWsClient(string $userid = 'user'): Client
    {
        $wsUri = (new Uri())
            ->withScheme('ws')
            ->withHost($this->host)
            ->withPath(sprintf('ws/%s', $userid))
            ->withPort($this->port)
        ;
        return new Client($wsUri, ['filter' => ['text']]);

    }


}