<?php

namespace Albocode\CcatphpSdk\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Phrity\Net\Uri;
use Psr\Http\Message\RequestInterface;

class HttpClient
{

    private Client $httpClient;
    private string $apikey;

    public function __construct(string $host, ?int $port = null, string $apikey = '', bool $isHTTPs = false)
    {
        $handlerStack = HandlerStack::create();
        $handlerStack->push(Middleware::tap($this->beforeSecureRequest()));

        $httpUri = (new Uri())
            ->withHost($host)
            ->withPort($port)
            ->withScheme($isHTTPs ? 'https' : 'http');

        $this->httpClient = new Client([
            'base_uri' => $httpUri,
            'handler' => $handlerStack
        ]);

        $this->apikey = $apikey;
    }

    /**
     * @return Client
     */
    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    protected function beforeSecureRequest(): \Closure
    {
        return function (RequestInterface &$request, array $requestOptions) {
            if (!empty($this->apikey)) {
                $request = $request->withHeader('access_token', $this->apikey);
            }
        };
    }

}