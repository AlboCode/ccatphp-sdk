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

    /**
     * @return array<string, null|array<string, mixed>>
     */
    public function toArray(): array
    {
        return [
            'episodic' => $this->episodic,
            'declarative' => $this->declarative,
            'procedural' => $this->declarative,
        ];
    }
}
