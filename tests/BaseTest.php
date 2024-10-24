<?php

namespace Albocode\CcatphpSdk\Tests;

use Albocode\CcatphpSdk\CCatClient;
use Albocode\CcatphpSdk\Endpoints\AbstractEndpoint;
use Albocode\CcatphpSdk\Tests\Mocks\TestHttpClient;
use Albocode\CcatphpSdk\Tests\Mocks\TestWsClient;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use WebSocket\Client as WsClient;
use WebSocket\Message\Message as WebSocketMessage;

class BaseTest extends TestCase
{
    protected string $apikey = 'apikey';
    protected string $token = 'token';

    /**
     * @throws \JsonException|Exception
     */
    public function testFailGetClientFromHttpClient(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('You must provide an apikey or a token');

        $httpClient = $this->getHttpClient();
        $httpClient->getClient();
    }

    /**
     * @throws \JsonException|Exception
     */
    public function testFailGetClientFromWSClient(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('You must provide an apikey or a token');

        $wsClient = $this->getWsClient();
        $wsClient->getClient();
    }

    /**
     * @throws \JsonException|Exception
     */
    public function testGetGuzzleClientsFromCCatClientWithApikeySuccess(): void
    {
        $cCatClient = $this->getCCatClient($this->apikey);

        self::assertInstanceOf(HttpClient::class, $cCatClient->getHttpClient()->getClient());
        self::assertInstanceOf(WsClient::class, $cCatClient->getWsClient()->getClient());
    }

    /**
     * @throws \JsonException|Exception
     */
    public function testGetGuzzleClientsFromCCatClientWithTokenSuccess(): void
    {
        $cCatClient = $this->getCCatClient();
        $cCatClient->addToken($this->token);

        self::assertInstanceOf(HttpClient::class, $cCatClient->getHttpClient()->getClient());
        self::assertInstanceOf(WsClient::class, $cCatClient->getWsClient()->getClient());
    }

    public function testFactorySuccess(): void
    {
        $cCatClient = $this->getCCatClient($this->apikey);
        $endpoint = $cCatClient->admins();

        self::assertInstanceOf(AbstractEndpoint::class, $endpoint);
    }

    /**
     * @throws \JsonException|Exception
     */
    protected function getCCatClient(
        ?string $apikey = null,
        ?array $content = null,
        ?int $code = null
    ): CCatClient {
        $httpClient = $this->getHttpClient($apikey, $content, $code);
        $wsClient = $this->getWsClient($apikey, $content);

        return new CCatClient($wsClient, $httpClient);
    }

    /**
     * @throws \JsonException|Exception
     */
    protected function getHttpClient(
        string $apikey = null,
        ?array $content = null,
        ?int $code = null,
        ?string $host = null,
        ?int $port = null,
    ): TestHttpClient {
        $content = $content ?? [];
        $code = $code ?? 200;
        $host = $host ?? 'example.com';
        $port = $port ?? 8080;

        return new TestHttpClient($this->getHttpClientMockGuzzle($content, $code), $host, $port, $apikey);
    }

    /**
     * @throws \JsonException|Exception
     */
    protected function getWsClient(
        ?string $apikey = null,
        ?array $content = null,
        ?string $host = null,
        ?int $port = null,
    ): TestWsClient{
        $content = $content ?? [];
        $host = $host ?? 'example.com';
        $port = $port ?? 8080;

        return new TestWsClient($this->getWebSocketClientMock($content), $host, $port, $apikey);
    }

    /**
     * @throws Exception|\JsonException
     */
    protected function getHttpClientMockGuzzle(?array $content = [], ?int $code = 200): HttpClient
    {
        // Convert array to JSON string if an array is provided
        $responseContent = json_encode($content, JSON_THROW_ON_ERROR);

        // Handle JSON encoding errors
        if (is_array($content) && json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Failed to encode content array as JSON: ' . json_last_error_msg());
        }

        // Create a mock PSR-7 Stream with the provided content
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('getContents')->willReturn($responseContent);
        $stream->method('__toString')->willReturn($responseContent);

        // Create a mock Response with the stream
        $response = $this->createMock(Response::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getStatusCode')->willReturn($code);

        // Create the HTTP client mock
        $httpClientMock = $this->createMock(HttpClient::class);

        // Configure all HTTP methods to return the response
        $methods = ['get', 'post', 'put', 'delete'];
        foreach ($methods as $method) {
            $httpClientMock
                ->method($method)
                ->willReturnCallback(function ($uri, array $options = []) use ($response) {
                    return $response;
                });
        }

        return $httpClientMock;
    }

    /**
     * @throws Exception|\JsonException
     */
    protected function getWebSocketClientMock(?array $content = []): WsClient
    {
        // Convert array to JSON string if an array is provided
        $responseContent = json_encode($content, JSON_THROW_ON_ERROR);

        // Create WebSocket Message stub
        $wsMessage = $this->createStub(WebSocketMessage::class);
        $wsMessage->method('getPayload')->willReturn($responseContent);
        $wsMessage->method('getContent')->willReturn($responseContent);
        $wsMessage->method('__toString')->willReturn($responseContent);

        $wsClientMock = $this->createMock(WsClient::class);
        $wsClientMock->method('receive')->willReturn($wsMessage);

        return $wsClientMock;
    }
}