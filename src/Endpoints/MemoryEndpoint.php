<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Memory\CollectionPointsDestroyOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\CollectionsOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\ConversationHistoryDeleteOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\ConversationHistoryOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\MemoryPointDeleteOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\MemoryPointOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\MemoryPointsDeleteByMetadataOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\MemoryPointsOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\MemoryRecallOutput;
use Albocode\CcatphpSdk\DTO\MemoryPoint;
use Albocode\CcatphpSdk\DTO\Why;
use Albocode\CcatphpSdk\Enum\Collection;
use Albocode\CcatphpSdk\Enum\Role;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class MemoryEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/memory';

    // -- Memory Collections API

    /**
     * This endpoint returns the collections of memory points, either for the agent identified by the agentId parameter
     * (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function getMemoryCollections(?string $agentId = null): CollectionsOutput
    {
        return $this->get(
            $this->formatUrl('/collections'),
            CollectionsOutput::class,
            $agentId,
        );
    }

    /**
     * This endpoint deletes the all the points in all the collections of memory, either for the agent identified by
     * the agentId parameter (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function deleteAllMemoryCollectionPoints(?string $agentId = null): CollectionPointsDestroyOutput
    {
        return $this->delete(
            $this->formatUrl('/collections'),
            CollectionPointsDestroyOutput::class,
            $agentId,
        );
    }

    /**
     * This method deletes all the points in a single collection of memory, either for the agent identified by the
     * agentId parameter (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function deleteAllSingleMemoryCollectionPoints(
        Collection $collection,
        ?string $agentId = null
    ): CollectionPointsDestroyOutput {
        return $this->delete(
            $this->formatUrl('/collections/' . $collection->value),
            CollectionPointsDestroyOutput::class,
            $agentId,
        );
    }

    // END Memory Collections API --

    // -- Memory Conversation History API

    /**
     * This endpoint returns the conversation history, either for the agent identified by the agentId parameter
     * (for multi-agent installations) or for the default agent (for single-agent installations). If the userId
     * parameter is provided, the conversation history is filtered by the user ID.
     *
     * @throws GuzzleException|\JsonException|RuntimeException
     */
    public function getConversationHistory(?string $agentId = null, ?string $userId = null): ConversationHistoryOutput
    {
        return $this->get(
            $this->formatUrl('/conversation_history'),
            ConversationHistoryOutput::class,
            $agentId,
            $userId,
        );
    }

    /**
     * This endpoint deletes the conversation history, either for the agent identified by the agentId parameter
     * (for multi-agent installations) or for the default agent (for single-agent installations). If the userId
     * parameter is provided, the conversation history is filtered by the user ID.
     *
     * @throws GuzzleException
     */
    public function deleteConversationHistory(
        ?string $agentId = null,
        ?string $userId = null
    ): ConversationHistoryDeleteOutput {
        return $this->delete(
            $this->formatUrl('/conversation_history'),
            ConversationHistoryDeleteOutput::class,
            $agentId,
            $userId,
        );
    }

    /**
     * This endpoint creates a new element in the conversation history, either for the agent identified by the agentId
     * parameter (for multi-agent installations) or for the default agent (for single-agent installations). If the
     * userId parameter is provided, the conversation history is added to the user ID.
     *
     * @param array<string, mixed>|null $images
     * @param array<string, mixed>|null $audio
     *
     * @throws GuzzleException
     */
    public function postConversationHistory(
        Role $who,
        string $text,
        ?array $images = null,
        ?array $audio = null,
        ?Why $why = null,
        ?string $agentId = null,
        ?string $userId = null
    ): ConversationHistoryOutput {
        $payload = [
            'who' => $who->value,
            'text' => $text,
        ];
        if ($images) {
            $payload['images'] = $images;
        }
        if ($audio) {
            $payload['audio'] = $audio;
        }
        if ($why) {
            $payload['why'] = $why->toArray();
        }

        return $this->postJson(
            $this->formatUrl('/conversation_history'),
            ConversationHistoryOutput::class,
            $payload,
            $agentId,
            $userId,
        );
    }

    // END Memory Conversation History API --

    // -- Memory Points API
    /**
     * This endpoint retrieves memory points based on the input text, either for the agent identified by the agentId
     * parameter (for multi-agent installations) or for the default agent (for single-agent installations). The text
     * parameter is the input text for which the memory points are retrieved. The k parameter is the number of memory
     * points to retrieve.
     * If the userId parameter is provided, the memory points are filtered by the user ID.
     *
     * @param array<string, mixed>|null $metadata
     *
     * @throws GuzzleException
     */
    public function getMemoryRecall(
        string $text,
        ?int $k = null,
        ?array $metadata = null,
        ?string $agentId = null,
        ?string $userId = null,
    ): MemoryRecallOutput {
        $query = ['text' => $text];
        if ($k) {
            $query['k'] = $k;
        }
        if ($metadata) {
            $query['metadata'] = $metadata;
        }

        return $this->get(
            $this->formatUrl('/recall'),
            MemoryRecallOutput::class,
            $agentId,
            $userId,
            $query,
        );
    }

    /**
     * This method posts a memory point, either for the agent identified by the agentId parameter (for multi-agent
     * installations) or for the default agent (for single-agent installations).
     * If the userId parameter is provided, the memory point is associated with the user ID.
     *
     * @throws GuzzleException
     */
    public function postMemoryPoint(
        Collection $collection,
        MemoryPoint $memoryPoint,
        ?string $agentId = null,
        ?string $userId = null,
    ): MemoryPointOutput {
        if ($userId && empty($memoryPoint->metadata['source'])) {
            $memoryPoint->metadata = !empty($memoryPoint->metadata)
                ? $memoryPoint->metadata + ['source' => $userId]
                : ['source' => $userId];
        }

        return $this->postJson(
            $this->formatUrl('/collections/' . $collection->value . '/points'),
            MemoryPointOutput::class,
            $memoryPoint->toArray(),
            $agentId,
        );
    }

    /**
     * This method puts a memory point, either for the agent identified by the agentId parameter (for multi-agent
     * installations) or for the default agent (for single-agent installations).
     * If the userId parameter is provided, the memory point is associated with the user ID.
     *
     * @throws GuzzleException
     */
    public function putMemoryPoint(
        Collection $collection,
        MemoryPoint $memoryPoint,
        string $pointId,
        ?string $agentId = null,
        ?string $userId = null,
    ): MemoryPointOutput {
        if ($userId && empty($memoryPoint->metadata['source'])) {
            $memoryPoint->metadata = !empty($memoryPoint->metadata)
                ? $memoryPoint->metadata + ['source' => $userId]
                : ['source' => $userId];
        }

        return $this->put(
            $this->formatUrl('/collections/' . $collection->value . '/points' . $pointId),
            MemoryPointOutput::class,
            $memoryPoint->toArray(),
            $agentId,
        );
    }

    /**
     * This endpoint retrieves a memory point, either for the agent identified by the agentId parameter (for multi-agent
     * installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function deleteMemoryPoint(
        Collection $collection,
        string $pointId,
        ?string $agentId = null,
    ): MemoryPointDeleteOutput {
        return $this->delete(
            $this->formatUrl('/collections/' . $collection->value . '/points/'. $pointId),
            MemoryPointDeleteOutput::class,
            $agentId,
        );
    }

    /**
     * This endpoint retrieves memory points based on the metadata, either for the agent identified by the agentId
     * parameter (for multi-agent installations) or for the default agent (for single-agent installations). The metadata
     * parameter is a dictionary of key-value pairs that the memory points must match.
     *
     * @param array<string, mixed>|null $metadata
     *
     * @throws GuzzleException
     */
    public function deleteMemoryPointsByMetadata(
        Collection $collection,
        ?array $metadata = null,
        ?string $agentId = null,
    ): MemoryPointsDeleteByMetadataOutput {
        return $this->delete(
            $this->formatUrl('/collections/' . $collection->value . '/points'),
            MemoryPointsDeleteByMetadataOutput::class,
            $agentId,
            null,
            $metadata ?? null,
        );
    }

    /**
     * This endpoint retrieves memory points, either for the agent identified by the agentId parameter (for multi-agent
     * installations) or for the default agent (for single-agent installations). The limit parameter is the maximum
     * number of memory points to retrieve. The offset parameter is the number of memory points to skip.
     *
     * @throws GuzzleException
     */
    public function getMemoryPoints(
        Collection $collection,
        ?int $limit = null,
        ?int $offset = null,
        ?string $agentId = null,
    ): MemoryPointsOutput {
        $query = [];
        if ($limit !== null) {
            $query['limit'] = $limit;
        }
        if ($offset !== null) {
            $query['offset'] = $offset;
        }

        return $this->get(
            $this->formatUrl('/collections/' . $collection->value . '/points'),
            MemoryPointsOutput::class,
            $agentId,
            null,
            $query ?: null,
        );
    }

    // END Memory Points API --
}