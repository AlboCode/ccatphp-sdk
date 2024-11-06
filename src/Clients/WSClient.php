<?php

namespace Albocode\CcatphpSdk\Clients;

use Phrity\Net\Uri;
use WebSocket\Client;
use WebSocket\Middleware\CloseHandler;
use WebSocket\Middleware\PingResponder;

class WSClient
{
    protected string $host;
    protected ?int $port;
    protected ?string $apikey;
    protected ?string $token;
    protected bool $isWSS;

    public function __construct(
        string $host,
        ?int $port = null,
        ?string $apikey = null,
        ?bool $isWSS = null,
    ) {

        $this->host = $host;
        $this->port = $port;
        $this->apikey = $apikey;
        $this->token = null;
        $this->isWSS = $isWSS ?? false;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function getClient(?string $agentId = null): Client
    {
        if (!$this->apikey && !$this->token) {
            throw new \InvalidArgumentException('You must provide an apikey or a token');
        }

        return $this->createWsClient($agentId);
    }

    public function getWsUri(?string $agentId = null): Uri
    {
        $path = sprintf('ws/%s', $agentId);
        $path .= $this->token ? '?token=' . $this->token : '?apikey=' . $this->apikey;

        return (new Uri())
            ->withScheme($this->isWSS ? 'wss' : 'ws')
            ->withHost($this->host)
            ->withPath($path)
            ->withPort($this->port)
        ;
    }

    protected function createWsClient(?string $agentId = null): Client
    {
        $client = new Client($this->getWsUri($agentId));
        $client->setPersistent(true)
            ->setTimeout(100000)
            // Add CloseHandler middleware
            ->addMiddleware(new CloseHandler())
            // Add PingResponder middleware
            ->addMiddleware(new PingResponder());
        return $client;
    }
}
