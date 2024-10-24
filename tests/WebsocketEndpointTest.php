<?php

namespace Albocode\CcatphpSdk\Tests;

use Albocode\CcatphpSdk\DTO\Message;
use Albocode\CcatphpSdk\DTO\Response;
use GuzzleHttp\Exception\GuzzleException;

class WebsocketEndpointTest extends BaseTest
{
    /**
     * @throws \JsonException|GuzzleException
     */
    public function testSendMessage(): void
    {
        $expected = [
            'content' => 'Hello World',
            'type' => 'chat',
            'user_id' => 'userID',
            'agent_id' => 'agentID',
            'why' => [
                'input' => 'input',
                'memory' => [
                    'episodic' => [],
                    'declarative' => [],
                    'procedural' => [],
                ],
            ],
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->websocket();
        $response = $endpoint->sendWebsocketMessage(
            new Message($expected['content'], $expected['user_id'], $expected['agent_id'])
        );

        self::assertInstanceOf(Response::class, $response);

        self::assertEquals($response->content, $expected['content']);
        self::assertEquals($response->type, $expected['type']);
        self::assertEquals($response->userId, $expected['user_id']);
        self::assertEquals($response->agentId, $expected['agent_id']);
        self::assertEquals($response->why->input, $expected['why']['input']);
        self::assertEquals($response->why->memory->episodic, $expected['why']['memory']['episodic']);
        self::assertEquals($response->why->memory->declarative, $expected['why']['memory']['declarative']);
        self::assertEquals($response->why->memory->procedural, $expected['why']['memory']['procedural']);
    }

}