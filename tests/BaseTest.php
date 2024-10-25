<?php

namespace Albocode\CcatphpSdk\Tests;

use Albocode\CcatphpSdk\Endpoints\AbstractEndpoint;
use Albocode\CcatphpSdk\Tests\Traits\TestTrait;
use GuzzleHttp\Client as HttpClient;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use WebSocket\Client as WsClient;

class BaseTest extends TestCase
{
    use TestTrait;

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
}