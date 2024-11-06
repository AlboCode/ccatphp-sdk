<?php

namespace Albocode\CcatphpSdk\Tests;

use Albocode\CcatphpSdk\Tests\Traits\TestTrait;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class HttpClientTest extends TestCase
{
    use TestTrait;

    /**
     * @throws GuzzleException
     */
    public function testSecureAuthorizationHeader(): void
    {
        $container = [];

        $client = $this->getMockedGuzzleClientWithHandlerStack($container);
        $client->getClient('agent', 'user')->get('/test');

        self::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = $container[0]['request'];

        self::assertTrue($request->hasHeader('Authorization'));
        self::assertEquals('Bearer ' . $this->apikey, $request->getHeader('Authorization')[0]);

        self::assertTrue($request->hasHeader('user_id'));
        self::assertEquals('user', $request->getHeader('user_id')[0]);

        self::assertTrue($request->hasHeader('agent_id'));
        self::assertEquals('agent', $request->getHeader('agent_id')[0]);
    }

    /**
     * @throws GuzzleException
     */
    public function testJwtAuthorizationHeader(): void
    {
        $container = [];

        $client = $this->getMockedGuzzleClientWithHandlerStack($container);
        $client->setToken($this->token);
        $client->getClient('agent', 'user')->get('/test');

        self::assertCount(1, $container);

        /** @var RequestInterface $request */
        $request = $container[0]['request'];

        self::assertTrue($request->hasHeader('Authorization'));
        self::assertEquals('Bearer ' . $this->token, $request->getHeader('Authorization')[0]);

        self::assertTrue($request->hasHeader('agent_id'));
        self::assertEquals('agent', $request->getHeader('agent_id')[0]);
    }
}