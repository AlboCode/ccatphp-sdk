<?php

namespace Albocode\CcatphpSdk\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Phrity\Net\Uri;
use Psr\Http\Message\RequestInterface;

class HttpClient
{
    private Client $httpClient;
    private Uri $httpUri;
    private ?string $apikey;
    private ?string $token;
    private ?string $userId = null;
    private ?string $agentId = null;

    public function __construct(
        string $host,
        ?int $port = null,
        ?string $apikey = null,
        ?bool $isHTTPs = false
    ) {
        $handlerStack = HandlerStack::create();
        $handlerStack->push(Middleware::tap($this->beforeSecureRequest()));
        $handlerStack->push(Middleware::tap($this->beforeJwtRequest()));

        $this->httpUri = (new Uri())
            ->withHost($host)
            ->withPort($port)
            ->withScheme($isHTTPs ? 'https' : 'http');

        $this->httpClient = $this->createHttpClient($handlerStack);

        $this->apikey = $apikey;
        $this->token = null;
    }

    public function createHttpClient(?HandlerStack $handlerStack = null): Client
    {
        $config = [
            'base_uri' => $this->httpUri,
        ];
        if ($handlerStack) {
            $config['handler'] = $handlerStack;
        }

        return new Client($config);
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

        $this->userId = $userId ?? 'user';
        $this->agentId = $agentId ?? 'agent';

        return $this->httpClient;
    }

    public function getHttpUri(): Uri
    {
        return $this->httpUri;
    }

    protected function beforeSecureRequest(): \Closure
    {
        return function (RequestInterface &$request, array $requestOptions) {
            if (!empty($this->apikey)) {
                $request = $request->withHeader('access_token', $this->apikey);
            }
            if (!empty($this->userId)) {
                $request = $request->withHeader('user_id', $this->userId);
            }
            if (!empty($this->agentId)) {
                $request = $request->withHeader('agent_id', $this->agentId);
            }
        };
    }

    protected function beforeJwtRequest(): \Closure
    {
        return function (RequestInterface &$request, array $requestOptions) {
            if (!empty($this->token)) {
                $request = $request->withHeader('Authorization', 'Bearer ' . $this->token);
            }
            if (!empty($this->userId)) {
                $request = $request->withHeader('user_id', $this->userId);
            }
            if (!empty($this->agentId)) {
                $request = $request->withHeader('agent_id', $this->agentId);
            }
        };
    }
}
