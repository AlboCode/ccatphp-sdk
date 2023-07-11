<?php

namespace Albocode\CcatphpSdk;

use Albocode\CcatphpSdk\Model\Memory;
use Albocode\CcatphpSdk\Model\Message;
use Albocode\CcatphpSdk\Model\Response;
use Albocode\CcatphpSdk\Model\Why;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Utils;
use Phrity\Net\Uri;
use WebSocket\Client as WSClient;

class CCatClient
{
    private WSClient $wsClient;
    private Client $httpClient;

    public function __construct(string $host, ?int $port = null, string $apikey = '')
    {
        //todo add support to wss and https
        $wsUri = (new Uri())
            ->withScheme('ws')
            ->withHost($host)
            ->withPath('ws')
            ->withPort($port)
        ;

        $this->wsClient = new WSClient($wsUri, ['filter' => ['text']]);

        $httpUri = (new Uri())
            ->withHost($host)
            ->withScheme('http');

        $this->httpClient = new Client([
            'base_uri' => $httpUri
        ]);
    }

    /**
     * @param Message $message
     * @return Response
     */
    public function sendMessage(Message $message): Response
    {

        $this->wsClient->text(json_encode($message));

        while (true) {
            try {
                $message = $this->wsClient->receive();
                break;
            } catch (\WebSocket\ConnectionException $e) {
                // Possibly log errors
            }
        }
        return $this->jsonToResponse($message);
    }

    /**
     * @param string $filePath
     * @param int|null $chunkSize
     * @param int|null $chunkOverlap
     * @return PromiseInterface
     */
    public function rabbitHole(string $filePath, ?int $chunkSize, ?int $chunkOverlap): PromiseInterface
    {
        $promise = $this->httpClient->postAsync('rabbithole/', [
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => Utils::tryFopen($filePath, 'r'),
                    'filename' => 'custom_filename.txt'
                ],
            ]
        ]);

        return $promise;
    }

    /**
     * @param string $webUrl
     * @param int|null $chunkSize
     * @param int|null $chunkOverlap
     * @return PromiseInterface
     */
    public function rabbitHoleWeb(string $webUrl, ?int $chunkSize, ?int $chunkOverlap): PromiseInterface
    {
        $promise = $this->httpClient->postAsync('rabbithole/web', [
            'body' => [
                'url' => $webUrl
            ]
        ]);

        return $promise;
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