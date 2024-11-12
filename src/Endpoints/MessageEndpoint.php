<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Message\MessageOutput;
use Albocode\CcatphpSdk\DTO\Message;
use Closure;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class MessageEndpoint extends AbstractEndpoint
{
    /**
     * This endpoint sends a message to the agent identified by the agentId parameter. The message is sent via HTTP.
     *
     * @throws GuzzleException|\Exception
     */
    public function sendHttpMessage(Message $message, ?string $agentId = null, ?string $userId = null): MessageOutput
    {
        return $this->postJson(
            '/message',
            MessageOutput::class,
            $message->toArray(),
            $agentId,
            $userId,
        );
    }

    /**
     * This endpoint sends a message to the agent identified by the agentId parameter. The message is sent via WebSocket.
     *
     * @throws \JsonException|Exception
     */
    public function sendWebsocketMessage(
        Message $message,
        ?string $agentId = null,
        ?string $userId = null,
        ?Closure $closure = null
    ): MessageOutput {
        $client = $this->getWsClient($agentId, $userId);
        $json = json_encode($message->toArray(), JSON_THROW_ON_ERROR);
        if (!$json) {
            throw new RuntimeException('Error encode message');
        }
        $client->text($json);

        while (true) {
            $response = $client->receive();
            if ($response === null) {
                throw new RuntimeException('Error receive message');
            }

            $content = $response->getContent();
            if (!str_contains($content, '"type":"chat"')) {
                $closure?->call($this, $content);
                continue;
            }
            break;
        }

        $client->disconnect();

        return $this->deserialize($content, MessageOutput::class);
    }
}