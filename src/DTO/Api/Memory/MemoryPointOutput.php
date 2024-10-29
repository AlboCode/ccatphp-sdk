<?php

namespace Albocode\CcatphpSdk\DTO\Api\Memory;

use Albocode\CcatphpSdk\DTO\MemoryPoint;

class MemoryPointOutput extends MemoryPoint
{
    public string $id;

    /** @var float[] */
    public array $vector;

}