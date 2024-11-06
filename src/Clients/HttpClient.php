<?php

namespace Albocode\CcatphpSdk\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Phrity\Net\Uri;
use Psr\Http\Message\RequestInterface;

class HttpClient
{
    protected Client $httpClient;
    protected Uri $httpUri;
    protected ?string $apikey;
    protected ?string $token;
    protected ?string $userId = null;
    protected ?string $agentId = null;

    /** @var array<string, callable> */
    protected array $middlewares;

    public function __construct(
        string $host,
        ?int $port = null,
        ?string $apikey = null,
        ?bool $isHTTPs = false
    ) {
        $this->apikey = $apikey;
        $this->token = null;

        $this->middlewares = [
            'beforeSecureRequest' => Middleware::tap($this->beforeSecureRequest()),
            'beforeJwtRequest' => Middleware::tap($this->beforeJwtRequest()),
        ];

        $handlerStack = HandlerStack::create();
        foreach ($this->middlewares as $name => $middleware) {
            $handlerStack->push($middleware, $name);
        }

        $this->httpUri = (new Uri())
            ->withHost($host)
            ->withPort($port)
            ->withScheme($isHTTPs ? 'https' : 'http');

        $this->httpClient = $this->createHttpClient($handlerStack);
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

        $this->agentId = $agentId ?? 'agent';
        $this->userId = $userId ?? 'user';

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
                $request = $request->withHeader('Authorization', 'Bearer ' . $this->apikey);
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
            if (!empty($this->agentId)) {
                $request = $request->withHeader('agent_id', $this->agentId);
            }
        };
    }
}
