<?php

namespace Albocode\CcatphpSdk\DTO;

class MemoryPoint
{
    public string $content;

    /** @var array<string, mixed> */
    public array $metadata;

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