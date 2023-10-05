<?php

namespace Albocode\CcatphpSdk;

use Albocode\CcatphpSdk\Clients\HttpClient;
use Albocode\CcatphpSdk\Clients\WSClient;
use Albocode\CcatphpSdk\Model\Memory;
use Albocode\CcatphpSdk\Model\Message;
use Albocode\CcatphpSdk\Model\Response;
use Albocode\CcatphpSdk\Model\Why;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\ResponseInterface;


class CCatClient
{
    protected WSClient $wsClient;
    protected HttpClient $httpClient;

    public function __construct(WSClient $wsClient, HttpClient $httpClient)
    {
        $this->wsClient = $wsClient;
        $this->httpClient = $httpClient;
    }

    /**
     * @param Message $message
     * @return Response
     * @throws \Exception
     */
    public function sendMessage(Message $message): Response
    {

        $this->wsClient->getWsClient()->text(json_encode($message));

        while (true) {
            try {
                $message = $this->wsClient->getWsClient()->receive();
                if (str_contains($message, "\"type\": \"notification\"")) {
                    continue;
                }
                if (empty($message)) {
                    throw new \Exception("Emptiy message from AI");
                }
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
        $promise = $this->httpClient->getHttpClient()->postAsync('rabbithole/', [
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
        $promise = $this->httpClient->getHttpClient()->postAsync('rabbithole/web', [
            'json' => [
                'url' => $webUrl
            ]
        ]);

        return $promise;
    }

    public function deleteDeclarativeMemoryByMetadata(array $metadata): ResponseInterface
    {
        return $this->httpClient->getHttpClient()->delete('memory/collections/declarative/points', [
            "json" => $metadata
        ]);
    }

    public function getMemoryCollection(): string
    {
        $response = $this->httpClient->getHttpClient()->get('/memory/collections/');

        return $response->getBody()->getContents();
    }

    public function getMemoryRecall(string $text, ?int $k = null, ?string $user_id = null): string
    {
        $response = $this->httpClient->getHttpClient()->get('/memory/recall/', [
            'query' => [
                'text' => $text
            ]
        ]);

        return $response->getBody()->getContents();
    }


    /**
     * @throws \Exception
     */
    private function  jsonToResponse(string $jsonResponse): Response
    {
        $response = new Response();
        $responseArray = json_decode($jsonResponse, true);
        if ($responseArray['type'] === 'error') {
            throw new \Exception($responseArray['description']);
        }
        $response->content = $responseArray['content'];
        $response->type = $responseArray['type'];
        $why = new Why();
        $why->input = $responseArray['why']['input'];
        $why->intermediate_steps = $responseArray['why']['intermediate_steps'];
        $memory = new Memory();
        $memory->declarative = $responseArray['why']['memory']['declarative'];
        $memory->episodic = $responseArray['why']['memory']['episodic'];
        $why->memory = $memory;
        $response->why = $why;
        return $response;
    }

}