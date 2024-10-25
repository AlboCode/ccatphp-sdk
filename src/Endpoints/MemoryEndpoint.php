<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Memory\CollectionsOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\CollectionsWipeOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\ConversationHistoryDeleteOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\ConversationHistoryOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\MemoryPointDeleteOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\MemoryPointOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\MemoryPointsDeleteByMetadataOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\MemoryPointsOutput;
use Albocode\CcatphpSdk\DTO\Api\Memory\MemoryRecallOutput;
use Albocode\CcatphpSdk\DTO\MemoryPoint;
use Albocode\CcatphpSdk\Enum\Collection;
use GuzzleHttp\Exception\GuzzleException;

class MemoryEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/memory';

    // -- Memory Collections API

    /**
     * @throws GuzzleException
     */
    public function getMemoryCollection(?string $agentId = null, ?string $userId = null): CollectionsOutput
    {
        return $this->get(
            $this->formatUrl('/collections'),
            CollectionsOutput::class,
            $agentId,
            $userId
        );
    }

    /**
     * @throws GuzzleException
     */
    public function deleteMemoryCollections(?string $agentId = null, ?string $userId = null): CollectionsWipeOutput
    {
        return $this->delete(
            $this->formatUrl('/collections'),
            CollectionsWipeOutput::class,
            $agentId,
            $userId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function deleteMemoryCollection(
        Collection $collection,
        ?string $agentId = null,
        ?string $userId = null
    ): CollectionsWipeOutput {
        return $this->delete(
            $this->formatUrl('/collections/' . $collection->value),
            CollectionsWipeOutput::class,
            $agentId,
            $userId,
        );
    }

    // END Memory Collections API --

    // -- Memory Conversation History API

    /**
     * @throws GuzzleException
     */
    public function getConversationHistory(?string $agentId = null, ?string $userId = null): ConversationHistoryOutput
    {
        return $this->get(
            $this->formatUrl('/conversation_history'),
            ConversationHistoryOutput::class,
            $agentId,
            $userId
        );
    }

    /**
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
            $userId
        );
    }

    // END Memory Conversation History API --

    // -- Memory Points API
    /**
     * @throws GuzzleException
     */
    public function getMemoryRecall(
        string $text,
        ?int $k = null,
        ?string $agentId = null,
        ?string $userId = null,
    ): MemoryRecallOutput {
        $query = ['text' => $text];
        if ($k) {
            $query['k'] = $k;
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
     * @throws GuzzleException
     */
    public function postMemoryPoint(
        Collection $collection,
        MemoryPoint $memoryPoint,
        ?string $agentId = null,
        ?string $userId = null,
    ): MemoryPointOutput {
        return $this->postJson(
            $this->formatUrl('/collections/' . $collection->value . '/points'),
            MemoryPointOutput::class,
            $memoryPoint->toArray(),
            $agentId,
            $userId,
        );
    }


    /**
     * @throws GuzzleException
     */
    public function deleteMemoryPoint(
        Collection $collection,
        string $pointId,
        ?string $agentId = null,
        ?string $userId = null,
    ): MemoryPointDeleteOutput {
        return $this->delete(
            $this->formatUrl('/collections/' . $collection->value . '/points/'. $pointId),
            MemoryPointDeleteOutput::class,
            $agentId,
            $userId,
        );
    }

    /**
     * @param array<string, mixed>|null $metadata
     *
     * @throws GuzzleException
     */
    public function deleteMemoryPointsByMetadata(
        Collection $collection,
        ?array $metadata = null,
        ?string $agentId = null,
        ?string $userId = null,
    ): MemoryPointsDeleteByMetadataOutput {
        return $this->delete(
            $this->formatUrl('/collections/' . $collection->value . '/points'),
            MemoryPointsDeleteByMetadataOutput::class,
            $agentId,
            $userId,
            $metadata ?? null,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getMemoryPoints(
        Collection $collection,
        ?int $limit = null,
        ?int $offset = null,
        ?string $agentId = null,
        ?string $userId = null,
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
            $userId,
            $query ?: null,
        );
    }

    // END Memory Points API --
}