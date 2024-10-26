<?php

namespace Albocode\CcatphpSdk\DTO;

class MemoryPoint
{
    public string $content;

    /** @var array<string, mixed> */
    public array $metadata;

    /**
     * @param array<string, mixed> $metadata
     */
    public function __construct(string $content, array $metadata)
    {
        $this->content = $content;
        $this->metadata = $metadata;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'metadata' => $this->metadata,
        ];
    }

}