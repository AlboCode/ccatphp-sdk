<?php

namespace Albocode\CcatphpSdk\Clients;

use Phrity\Net\Uri;
use WebSocket\Client;
use WebSocket\Middleware\CloseHandler;
use WebSocket\Middleware\PingResponder;

class WSClient
{

    private string $host;
    private ?int $port;
    private string $apikey;
    private bool $isWSS;

    public function __construct(string $host, ?int $port = null, string $apikey = '', bool $isWSS = false)
    {
        //todo add support to wss

        $this->host = $host;
        $this->port = $port;
        $this->apikey = $apikey;
        $this->isWSS = $isWSS;
    }

    /**
     * @return Client
     */
    public function getWsClient(string $userid = 'user'): Client
    {
        $wsUri = (new Uri())
            ->withScheme($this->isWSS ? 'wss' : 'ws')
            ->withHost($this->host)
            ->withPath(sprintf('ws/%s', $userid))
            ->withPort($this->port)
        ;
        $client = new Client($wsUri);
        $client->setPersistent(true)
            ->setTimeout(100000)
            // Add CloseHandler middleware
            ->addMiddleware(new CloseHandler())
            // Add PingResponder middleware
            ->addMiddleware(new PingResponder());
        return $client;
    }


}