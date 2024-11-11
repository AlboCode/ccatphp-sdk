<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Closure;
use Exception;
use RuntimeException;
use Albocode\CcatphpSdk\DTO\Message;
use Albocode\CcatphpSdk\DTO\Response;
use GuzzleHttp\Exception\GuzzleException;

class MessageEndpoint extends AbstractEndpoint
{
    /**
     * This endpoint sends a message to the agent identified by the agentId parameter. The message is sent via HTTP.
     *
     * @throws GuzzleException|\Exception
     */
    public function sendHttpMessage(Message $message, ?string $agentId = null, ?string $userId = null): Response
    {
        $httpClient = $this->getHttpClient($agentId, $userId);
        $response = $httpClient->post('/message', ['json' => $message->toArray()]);

        return $this->jsonToResponse($response->getBody()->getContents());
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
    ): Response {
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

        return $this->jsonToResponse($content);
    }
}