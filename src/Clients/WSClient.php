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
    private ?string $apikey;
    private ?string $token;
    private bool $isWSS;

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

    public function getClient(?string $agentId = null, ?string $userId = null): Client
    {
        if (!$this->apikey && !$this->token) {
            throw new \InvalidArgumentException('You must provide an apikey or a token');
        }

        return $this->createWsClient($agentId, $userId);
    }

    protected function createWsClient(?string $agentId = null, ?string $userId = null): Client
    {
        $userId = $userId ?? 'user';
        $agentId = $agentId ?? 'agent';

        $path = sprintf('ws/%s/%s', $userId, $agentId);
        $path .= $this->apikey ? '?apikey=' . $this->apikey : '?token=' . $this->token;

        $wsUri = (new Uri())
            ->withScheme($this->isWSS ? 'wss' : 'ws')
            ->withHost($this->host)
            ->withPath($path)
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
