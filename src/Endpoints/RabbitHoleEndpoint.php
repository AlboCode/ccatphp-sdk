<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\RabbitHole\AllowedMimeTypesOutput;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Utils;

class RabbitHoleEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/rabbithole';

    public function postFile(
        string $filePath,
        ?string $fileName,
        ?int $chunkSize,
        ?int $chunkOverlap,
        ?string $agentId = null,
        ?string $loggedUserId = null,
    ): PromiseInterface {
        $fileName = $fileName ?: basename($filePath);

        return $this->getHttpClient($agentId, $loggedUserId)->postAsync($this->prefix, [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => Utils::tryFopen($filePath, 'r'),
                    'filename' => $fileName,
                ],
                [
                    'name' => 'chunk_size',
                    'contents' => $chunkSize ?? null,
                ],
                [
                    'name' => 'chunk_overlap',
                    'contents' => $chunkOverlap ?? null,
                ],
            ],
        ]);
    }

    /**
     * @param string[] $filePaths
     */
    public function postFiles(
        array $filePaths,
        ?int $chunkSize = null,
        ?int $chunkOverlap = null,
        ?string $agentId = null,
        ?string $loggedUserId = null,
    ): PromiseInterface {
        $multipartData = [];

        foreach ($filePaths as $filePath) {
            $multipartData[] = [
                'name' => 'files',
                'contents' => Utils::tryFopen($filePath, 'r'),
                'filename' => basename($filePath),
            ];
        }

        if ($chunkSize !== null) {
            $multipartData[] = [
                'name' => 'chunk_size',
                'contents' => $chunkSize,
            ];
        }

        if ($chunkOverlap !== null) {
            $multipartData[] = [
                'name' => 'chunk_overlap',
                'contents' => $chunkOverlap,
            ];
        }

        return $this->getHttpClient($agentId, $loggedUserId)->postAsync($this->formatUrl('/batch'), [
            'multipart' => $multipartData,
        ]);
    }

    public function postWeb(
        string $webUrl,
        ?int $chunkSize = null,
        ?int $chunkOverlap = null,
        ?string $agentId = null,
        ?string $loggedUserId = null
    ): PromiseInterface {
        $payload = ['url' => $webUrl];
        if ($chunkSize) {
            $payload['chunk_size'] = $chunkSize;
        }
        if ($chunkOverlap) {
            $payload['chunk_overlap'] = $chunkOverlap;
        }

        return $this->getHttpClient($agentId, $loggedUserId)->postAsync($this->formatUrl('/web'), [
            'json' => $payload,
        ]);
    }

    public function postMemory(
        string $filePath,
        ?string $fileName,
        ?string $agentId = null,
        ?string $loggedUserId = null,
    ): PromiseInterface {
        $fileName = $fileName ?: basename($filePath);

        return $this->getHttpClient($agentId, $loggedUserId)->postAsync($this->formatUrl('/memory'), [
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
     * @throws GuzzleException
     */
    public function getAllowedMimeTypes(?string $agentId = null, ?string $loggedUserId = null): AllowedMimeTypesOutput
    {
        return $this->get(
            $this->formatUrl('/allowed-mimetypes'),
            AllowedMimeTypesOutput::class,
            $agentId,
            $loggedUserId
        );
    }
}