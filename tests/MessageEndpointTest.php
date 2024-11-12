<?php

namespace Albocode\CcatphpSdk\Tests;

use Albocode\CcatphpSdk\DTO\Api\Message\MessageOutput;
use Albocode\CcatphpSdk\DTO\Message;
use Albocode\CcatphpSdk\Tests\Traits\TestTrait;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class MessageEndpointTest extends TestCase
{
    use TestTrait;

    /**
     * @throws \JsonException|GuzzleException|Exception
     */
    public function testSendHttpMessage(): void
    {
        $expected = [
            'text' => 'Hello World',
            'type' => 'chat',
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

        $endpoint = $cCatClient->message();
        $response = $endpoint->sendHttpMessage(
            new Message($expected['text']), 'agent_id', 'user_id'
        );

        self::assertInstanceOf(MessageOutput::class, $response);

        self::assertEquals($response->text, $expected['text']);
        self::assertEquals($response->type, $expected['type']);
        self::assertEquals($response->why->input, $expected['why']['input']);
        self::assertEquals($response->why->memory->episodic, $expected['why']['memory']['episodic']);
        self::assertEquals($response->why->memory->declarative, $expected['why']['memory']['declarative']);
        self::assertEquals($response->why->memory->procedural, $expected['why']['memory']['procedural']);
    }

    /**
     * @throws \JsonException|GuzzleException|Exception
     */
    public function testSendWebsocketMessage(): void
    {
        $expected = [
            'text' => 'Hello World',
            'type' => 'chat',
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

        $endpoint = $cCatClient->message();
        $response = $endpoint->sendWebsocketMessage(
            new Message($expected['text']), 'agent_id', 'user_id'
        );

        self::assertInstanceOf(MessageOutput::class, $response);

        self::assertEquals($response->text, $expected['text']);
        self::assertEquals($response->type, $expected['type']);
        self::assertEquals($response->why->input, $expected['why']['input']);
        self::assertEquals($response->why->memory->episodic, $expected['why']['memory']['episodic']);
        self::assertEquals($response->why->memory->declarative, $expected['why']['memory']['declarative']);
        self::assertEquals($response->why->memory->procedural, $expected['why']['memory']['procedural']);
    }
}