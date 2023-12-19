<?php

namespace Albocode\CcatphpSdk;

use Albocode\CcatphpSdk\Clients\HttpClient;
use Albocode\CcatphpSdk\Clients\WSClient;
use Albocode\CcatphpSdk\Model\Api\LLMSetting\LLMSettingsOutput;
use Albocode\CcatphpSdk\Model\Api\Plugin\PluginCollectionOutput;
use Albocode\CcatphpSdk\Model\Api\Plugin\Settings\PluginSettingsOutput;
use Albocode\CcatphpSdk\Model\Api\RabbitHole\AllowedMimeTypesOutput;
use Albocode\CcatphpSdk\Model\Api\Setting\SettingOutputItem;
use Albocode\CcatphpSdk\Model\Api\Setting\SettingsOutputCollection;
use Albocode\CcatphpSdk\Model\Memory;
use Albocode\CcatphpSdk\Model\Message;
use Albocode\CcatphpSdk\Model\Response;
use Albocode\CcatphpSdk\Model\Why;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\PropertyInfo\Extractor\ConstructorExtractor;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CCatClient
{
    protected WSClient $wsClient;
    protected HttpClient $httpClient;

    private Serializer $serializer;

    public function __construct(WSClient $wsClient, HttpClient $httpClient)
    {
        $this->wsClient = $wsClient;
        $this->httpClient = $httpClient;
        $phpDocExtractor = new PhpDocExtractor();
        $typeExtractor   = new PropertyInfoExtractor(
            typeExtractors: [ new ConstructorExtractor([$phpDocExtractor]), $phpDocExtractor,]
        );
        $normalizer = new ObjectNormalizer(
            null,
            new CamelCaseToSnakeCaseNameConverter(),
            null,
            propertyTypeExtractor: $typeExtractor
        );

        $encoder = new JsonEncoder();

        $this->serializer = new Serializer([$normalizer, new ArrayDenormalizer()], [$encoder]);
    }


    /**
     * @param Message $message
     * @return Response
     * @throws \Exception
     */
    public function sendMessage(Message $message, ?\Closure $closure = null): Response
    {
        $client = $this->wsClient->getWsClient($message->user_id);
        $json = json_encode($message);
        if (!$json) {
            throw new \Exception("Error encode message");
        }
        $client->text($json);

        while (true) {

            $response = $client->receive();
            $message = $response->getContent();
            if (!str_contains($message, "\"type\":\"chat\"")) {
                $closure?->call($this, $message);
                continue;
            }
            break;

        }

        $client->disconnect();

        return $this->jsonToResponse($message);
    }

    /**
     * @param string $filePath
     * @param int|null $chunkSize
     * @param int|null $chunkOverlap
     * @return PromiseInterface
     */
    public function rabbitHole(string $filePath, ?string $fileName, ?int $chunkSize, ?int $chunkOverlap): PromiseInterface
    {
        $promise = $this->httpClient->getHttpClient()->postAsync('rabbithole/', [
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => Utils::tryFopen($filePath, 'r'),
                    'filename' => $fileName ?? null
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


    public function getAllowedMimeTypes(): AllowedMimeTypesOutput
    {
        $response = $this->httpClient->getHttpClient()->get(sprintf('/rabbithole/allowed-mimetypes'));

        return $this->serializer->deserialize($response->getBody()->getContents(), AllowedMimeTypesOutput::class, 'json', []);
    }
    // -- Memory API
    /**
     * @param array<string, mixed> $metadata
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
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
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteConversationHistory(string $userId = "user"): ResponseInterface
    {
        return $this->httpClient->getHttpClient()->delete("/memory/conversation_history", [
            "headers" => [
                "user_id" => $userId
            ]
        ]);
    }
    // Memory API --
    // -- Settings API
    public function getSettings(): SettingsOutputCollection
    {
        $response = $this->httpClient->getHttpClient()->get('/settings');

        return $this->serializer->deserialize($response->getBody()->getContents(), SettingsOutputCollection::class, 'json', []);
    }

    public function getSetting(string $settingId): SettingOutputItem
    {
        $response = $this->httpClient->getHttpClient()->get(sprintf('/settings/%s', $settingId));

        return $this->serializer->deserialize($response->getBody()->getContents(), SettingOutputItem::class, 'json', []);
    }

    /**
     * @param string $settingId
     * @param array<string, mixed> $values
     * @return SettingOutputItem
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function putSetting(string $settingId, array $values): SettingOutputItem
    {
        $response = $this->httpClient->getHttpClient()->put(sprintf('/settings/%s', $settingId), [
            'json' => $values
        ]);

        return $this->serializer->deserialize($response->getBody()->getContents(), SettingOutputItem::class, 'json', []);
    }


    public function deleteSetting(string $settingId): ResponseInterface
    {
        return $this->httpClient->getHttpClient()->delete(sprintf('/settings/%s', $settingId));
    }
    // END Settings --

    // Plugins API --
    public function getPlugins(?string $query = null): PluginCollectionOutput
    {
        $response = $this->httpClient->getHttpClient()->get('/plugins', [
            'query' => ['query' => $query]
        ]);

        return $this->serializer->deserialize($response->getBody()->getContents(), PluginCollectionOutput::class, 'json', []);
    }

    /**
     * @param string $pluginId
     * @return array<mixed>
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function togglePlugin(string $pluginId): array
    {
        $response = $this->httpClient->getHttpClient()->put(sprintf('/plugins/toggle/%s', $pluginId), [
        ]);

        return $this->serializer->decode($response->getBody()->getContents(), 'json', []);
    }

    /**
     * @param string $url
     * @return array<mixed>
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function installPluginFromRegistry(string $url): array
    {
        $response = $this->httpClient->getHttpClient()->post(sprintf('/plugins/upload/registry'), [
            'json' => [
                'url' => $url
            ]
        ]);

        return $this->serializer->decode($response->getBody()->getContents(), 'json', []);

    }

    public function getPluginSettings(string $pluginId): PluginSettingsOutput
    {
        $response = $this->httpClient->getHttpClient()->get(sprintf('/plugins/settings/%s', $pluginId), []);
        return $this->serializer->deserialize($response->getBody()->getContents(), PluginSettingsOutput::class, 'json', []);

    }

    public function getLLMSettings(string $llm): LLMSettingsOutput
    {
        $response = $this->httpClient->getHttpClient()->get(sprintf('/llm/settings/%s', $llm), []);
        return $this->serializer->deserialize($response->getBody()->getContents(), LLMSettingsOutput::class, 'json', []);
    }

    /**
     * @param string $llm
     * @param array<string, mixed> $values
     * @return LLMSettingsOutput
     */
    public function putLLMSettings(string $llm, array $values): LLMSettingsOutput
    {
        $response = $this->httpClient->getHttpClient()->put(sprintf('/llm/settings/%s', $llm), [
            'json' => $values
        ]);
        return $this->serializer->deserialize($response->getBody()->getContents(), LLMSettingsOutput::class, 'json', []);
    }

    /**
     * @param string $embedder
     * @param array<string, mixed> $values
     * @return LLMSettingsOutput
     */
    public function putEmbedderSettings(string $embedder, array $values): LLMSettingsOutput
    {
        $response = $this->httpClient->getHttpClient()->put(sprintf('/embedder/settings/%s', $embedder), [
            'json' => $values
        ]);
        return $this->serializer->deserialize($response->getBody()->getContents(), LLMSettingsOutput::class, 'json', []);
    }

    /**
     * @param string $embedder
     * @return LLMSettingsOutput
     */
    public function getEmbedderSettings(string $embedder): LLMSettingsOutput
    {
        $response = $this->httpClient->getHttpClient()->get(sprintf('/embedder/settings/%s', $embedder));
        return $this->serializer->deserialize($response->getBody()->getContents(), LLMSettingsOutput::class, 'json', []);
    }

    /**
     * @param string $pluginId
     * @param array<string, mixed> $values
     * @return PluginSettingsOutput
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function putPluginSettings(string $pluginId, array $values): PluginSettingsOutput
    {
        $response = $this->httpClient->getHttpClient()->put(sprintf('/plugins/settings/%s', $pluginId), [
            "json" => $values
        ]);
        return $this->serializer->deserialize($response->getBody()->getContents(), PluginSettingsOutput::class, 'json', []);
    }
    /**
     * @throws \Exception
     */
    private function jsonToResponse(string $jsonResponse): Response
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
        $why->intermediate_steps = $responseArray['why']['intermediate_steps'] ?? [];
        $memory = new Memory();
        $memory->declarative = $responseArray['why']['memory']['declarative'];
        $memory->episodic = $responseArray['why']['memory']['episodic'];
        $why->memory = $memory;
        $response->why = $why;
        return $response;
    }

}
