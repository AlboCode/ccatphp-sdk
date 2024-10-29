<?php

namespace Albocode\CcatphpSdk\DTO\Api\Memory\Nested;

class MemoryRecallVectors
{
    public string $embedder;

    /** @var array<string, array<array<string, mixed>>> */
    public array $collections;
}
