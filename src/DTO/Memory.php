<?php

namespace Albocode\CcatphpSdk\DTO;

class Memory
{
    /** @var array<string, mixed>|null */
    public ?array $episodic = [];

    /** @var array<string, mixed>|null */
    public ?array $declarative = [];

    /** @var array<string, mixed>|null */
    public ?array $procedural = [];
}
