<?php

namespace Albocode\CcatphpSdk\Model;

class Memory
{
    /**
     * @var array<string, mixed>
     */
    public array $episodic;

    /**
     * @var array<string, mixed>
     */
    public array $declarative = [];

    /**
     * @var array<string, mixed>
     */
    public array $procedural = [];

}
