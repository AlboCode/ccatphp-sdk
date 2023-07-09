<?php

namespace Albocode\CcatphpSdk;

use Albocode\CcatphpSdk\Model\Memory;
use Albocode\CcatphpSdk\Model\Message;
use Albocode\CcatphpSdk\Model\Response;
use Albocode\CcatphpSdk\Model\Why;
use Phrity\Net\Uri;
use WebSocket\Client as WSClient;

class CCatClient
{
    private WSClient $wsClient;
    public function __construct(string $host, ?int $port = null, string $apikey = '')
    {
        $wsUri = (new Uri())
            ->withScheme('ws')
            ->withHost($host)
            ->withPath('ws')
            ->withPort($port)
        ;

        $this->wsClient = new WSClient($wsUri, ['filter' => ['text']]);
    }

    public function sendMessage(Message $message): Response
    {

        $this->wsClient->send(json_encode($message));
        return $this->jsonToResponse($this->wsClient->receive());
    }

    private function  jsonToResponse(string $jsonResponse): Response
    {
        $response = new Response();
        $responseArray = json_decode($jsonResponse, true);
        $response->content = $responseArray['content'];
        $response->type = $responseArray['type'];
        $response->error = $responseArray['error'];
        $why = new Why();
        $why->input = $responseArray['why']['input'];
        $why->intermediate_steps = $responseArray['why']['intermediate_steps'];
        $memory = new Memory();
        $memory->declarative = $responseArray['why']['memory']['declarative'];
        $memory->episodic = $responseArray['why']['memory']['episodic'];
        $memory->procedural = $responseArray['why']['memory']['procedural'];
        $why->memory = $memory;
        $response->why = $why;
        return $response;
    }

}