<?php

namespace Albocode\CcatphpSdk\DTO\Api\Memory;


use Albocode\CcatphpSdk\DTO\Api\Memory\Nested\MemoryRecallQuery;
use Albocode\CcatphpSdk\DTO\Api\Memory\Nested\MemoryRecallVectors;

class MemoryRecallOutput
{
    /** @var MemoryRecallQuery */
    public MemoryRecallQuery $query;

    /** @var MemoryRecallVectors */
    public MemoryRecallVectors $vectors;
}