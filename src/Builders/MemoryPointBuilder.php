<?php

namespace Albocode\CcatphpSdk\Builders;

use Albocode\CcatphpSdk\DTO\MemoryPoint;

class MemoryPointBuilder implements BaseBuilder
{
    private string $content;

    /** @var array<string, mixed> */
    private array $metadata;

    public static function create(): MemoryPointBuilder
    {
        return new self();
    }

    public function setContent(string $content): MemoryPointBuilder
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param array<string, mixed> $metadata
     */
    public function setMetadata(array $metadata): MemoryPointBuilder
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function build(): MemoryPoint
    {
        return new MemoryPoint($this->content, $this->metadata);
    }
}