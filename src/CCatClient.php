<?php

namespace Albocode\CcatphpSdk;

use Phrity\Net\Uri;
use WebSocket\Client as WSClient;

class CCatClient
{
    private WSClient $wsClient;
    public function __construct(string $host, int $port, string $apikey)
    {
        $wsUri = (new Uri())
            ->withScheme('ws')
            ->withHost($host)
            ->withPort($port)
        ;
        $this->wsClient = new WSClient($wsUri);
    }

    public function sendMessage(string $message, string $user_id = ''): string
    {
        return '';
    }

}