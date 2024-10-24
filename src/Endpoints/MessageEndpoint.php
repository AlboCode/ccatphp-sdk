<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Message;
use Albocode\CcatphpSdk\DTO\Response;
use GuzzleHttp\Exception\GuzzleException;

class MessageEndpoint extends AbstractEndpoint
{
    /**
     * @throws GuzzleException|\Exception
     */
    public function sendHttpMessage(Message $message): Response
    {
        $httpClient = $this->getHttpClient($message->agentId, $message->userId);
        $response = $httpClient->post('/message', ['json' => ['text' => $message->text]]);

        return $this->jsonToResponse($response->getBody()->getContents());
    }
}