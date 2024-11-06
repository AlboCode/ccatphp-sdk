<?php

namespace Albocode\CcatphpSdk\Tests;

use Albocode\CcatphpSdk\Clients\WSClient;
use Albocode\CcatphpSdk\Tests\Traits\TestTrait;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class WsClientTest extends TestCase
{
    use TestTrait;

    /**
     * @throws GuzzleException
     */
    public function testClientWithApiKey(): void
    {
        $wsClient = new WSClient('example.com', 8080, $this->apikey);
        $guzzleUri = $wsClient->getWsUri();

        self::assertEquals(
            'ws://example.com:8080/ws/?apikey=' . $this->apikey,
            urldecode($guzzleUri->toString())
        );
    }

    /**
     * @throws GuzzleException
     */
    public function testClientWithToken(): void
    {
        $wsClient = new WSClient('example.com', 8080, $this->apikey);
        $wsClient->setToken($this->token);
        $guzzleUri = $wsClient->getWsUri();

        self::assertEquals(
            'ws://example.com:8080/ws/?token=' . $this->token,
            urldecode($guzzleUri->toString())
        );
    }
}