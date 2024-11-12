<?php

namespace Albocode\CcatphpSdk\DTO\Api\Memory;

use Albocode\CcatphpSdk\DTO\Api\Memory\Nested\Record;

class MemoryPointsOutput
{
    /** @var Record[] */
    public array $points;

    public string|int|null $nextOffset = null;
}