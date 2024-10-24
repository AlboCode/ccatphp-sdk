<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Message;
use Albocode\CcatphpSdk\DTO\Response;
use Closure;
use Exception;
use RuntimeException;

class WebsocketEndpoint extends AbstractEndpoint
{
    /**
     * @throws \JsonException|Exception
     */
    public function sendWebsocketMessage(Message $message, ?Closure $closure = null): Response
    {
        $client = $this->getWsClient($message->agentId, $message->userId);
        $json = json_encode($message, JSON_THROW_ON_ERROR);
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