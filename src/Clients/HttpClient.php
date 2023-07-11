<?php

namespace Albocode\CcatphpSdk\Clients;

use GuzzleHttp\Client;
use Phrity\Net\Uri;

class HttpClient
{

    private Client $httpClient;

    public function __construct(string $host, ?int $port = null, string $apikey = '')
    {
//todo add support to https
        $httpUri = (new Uri())
            ->withHost($host)
            ->withPort($port)
            ->withScheme('http');

        $this->httpClient = new Client([
            'base_uri' => $httpUri
        ]);
    }

    /**
     * @return Client
     */
    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }


}