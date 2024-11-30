<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\RabbitHole\AllowedMimeTypesOutput;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Utils;

class RabbitHoleEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/rabbithole';

    /**
     * This method posts a file to the RabbitHole API. The file is uploaded to the RabbitHole server and ingested into
     * the RAG system. The file is then processed by the RAG system and the results are stored in the RAG database.
     * The process is asynchronous and the results are returned in a batch.
     * The CheshireCat processes the injection in background and the client will be informed at the end of the process.
     */
    public function postFile(
        string $filePath,
        ?string $fileName,
        ?int $chunkSize = null,
        ?int $chunkOverlap = null,
        ?string $agentId = null,
        ?array $metadata = null,
    ): PromiseInterface {
        $fileName = $fileName ?: basename($filePath);

        $multipartData = [
            [
                'name' => 'file',
                'contents' => Utils::tryFopen($filePath, 'r'),
                'filename' => $fileName,
            ]
        ];

        if ($chunkSize) {
            $multipartData[] = [
                'name' => 'chunk_size',
                'contents' => $chunkSize,
            ];
        }

        if ($chunkOverlap) {
            $multipartData[] = [
                'name' => 'chunk_overlap',
                'contents' => $chunkOverlap,
            ];
        }

        if ($metadata) {
            $multipartData[] = [
                'name' => 'metadata',
                'contents' => json_encode($metadata)
            ];
        }

        return $this->getHttpClient($agentId)->postAsync($this->prefix, ['multipart' => $multipartData]);
    }

    /**
     * This method posts a number of files to the RabbitHole API. The files are uploaded to the RabbitHole server and
     * ingested into the RAG system. The files are then processed by the RAG system and the results are stored in the
     * RAG database. The files are processed in a batch. The process is asynchronous.
     * The CheshireCat processes the injection in background and the client will be informed at the end of the process.
     *
     * @param string[] $filePaths
     */
    public function postFiles(
        array $filePaths,
        ?int $chunkSize = null,
        ?int $chunkOverlap = null,
        ?string $agentId = null,
        ?array $metadata = null,
    ): PromiseInterface {
        $multipartData = [];

        foreach ($filePaths as $filePath) {
            $multipartData[] = [
                'name' => 'files',
                'contents' => Utils::tryFopen($filePath, 'r'),
                'filename' => basename($filePath),
            ];
        }

        if ($chunkSize) {
            $multipartData[] = [
                'name' => 'chunk_size',
                'contents' => $chunkSize,
            ];
        }

        if ($chunkOverlap) {
            $multipartData[] = [
                'name' => 'chunk_overlap',
                'contents' => $chunkOverlap,
            ];
        }

        if ($metadata) {
            $multipartData[] = [
                'name' => 'metadata',
                'contents' => json_encode($metadata)
            ];
        }
        
        return $this->getHttpClient($agentId)->postAsync($this->formatUrl('/batch'), [
            'multipart' => $multipartData,
        ]);
    }

    /**
     * This method posts a web URL to the RabbitHole API. The web URL is ingested into the RAG system. The web URL is
     * processed by the RAG system by Web scraping and the results are stored in the RAG database. The process is
     * asynchronous.
     * The CheshireCat processes the injection in background and the client will be informed at the end of the process.
     */
    public function postWeb(
        string $webUrl,
        ?int $chunkSize = null,
        ?int $chunkOverlap = null,
        ?string $agentId = null,
        ?array $metadata = null,
    ): PromiseInterface {
        $payload = ['url' => $webUrl];
        if ($chunkSize) {
            $payload['chunk_size'] = $chunkSize;
        }
        if ($chunkOverlap) {
            $payload['chunk_overlap'] = $chunkOverlap;
        }
        if ($metadata) {
            $payload['metadata'] = $metadata;
        }
        
        return $this->getHttpClient($agentId)->postAsync($this->formatUrl('/web'), [
            'json' => $payload,
        ]);
    }

    /**
     * This method posts a memory point, either for the agent identified by the agentId parameter (for multi-agent
     * installations) or for the default agent (for single-agent installations). The memory point is ingested into the
     * RAG system. The process is asynchronous. The provided file must be in JSON format.
     * The CheshireCat processes the injection in background and the client will be informed at the end of the process.
     */
    public function postMemory(
        string $filePath,
        ?string $fileName,
        ?string $agentId = null,
    ): PromiseInterface {
        $fileName = $fileName ?: basename($filePath);

        return $this->getHttpClient($agentId)->postAsync($this->formatUrl('/memory'), [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => Utils::tryFopen($filePath, 'r'),
                    'filename' => $fileName,
                ],
            ],
        ]);
    }

    /**
     * This method retrieves the allowed MIME types for the RabbitHole API. The allowed MIME types are the MIME types
     * that are allowed to be uploaded to the RabbitHole API. The allowed MIME types are returned in a list.
     * If the agentId parameter is provided, the allowed MIME types are retrieved for the agent identified by the
     * agentId parameter (for multi-agent installations). If the agentId parameter is not provided, the allowed MIME
     * types are retrieved for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function getAllowedMimeTypes(?string $agentId = null): AllowedMimeTypesOutput
    {
        return $this->get(
            $this->formatUrl('/allowed-mimetypes'),
            AllowedMimeTypesOutput::class,
            $agentId,
        );
    }
}
