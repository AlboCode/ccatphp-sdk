<?php

namespace Albocode\CcatphpSdk\DTO\Api\Memory\Nested;

class Record
{
    public string $id;

    /** @var array<string, mixed>|null  */
    public ?array $payload;

    /** @var float[]|null  */
    public ?array $vector;

    public ?string $shardKey;

    public ?float $orderValue;
}