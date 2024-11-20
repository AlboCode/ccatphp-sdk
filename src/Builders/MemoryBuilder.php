<?php

namespace Albocode\CcatphpSdk\Builders;

use Albocode\CcatphpSdk\DTO\Memory;

class MemoryBuilder implements BaseBuilder
{
    /** @var array<string, mixed>|null */
    private ?array $episodic = [];

    /** @var array<string, mixed>|null */
    private ?array $declarative = [];

    /** @var array<string, mixed>|null */
    private ?array $procedural = [];

    public static function create() : MemoryBuilder
    {
        return new self();
    }

    /**
     * @param array<string, mixed> $episodic
     */
    public function setEpisodic(?array $episodic = null): MemoryBuilder
    {
        $this->episodic = $episodic ?? [];

        return $this;
    }

    /**
     * @param array<string, mixed> $declarative
     */
    public function setDeclarative(?array $declarative = null): MemoryBuilder
    {
        $this->declarative = $declarative ?? [];

        return $this;
    }

    /**
     * @param array<string, mixed> $procedural
     */
    public function setProcedural(?array $procedural = null): MemoryBuilder
    {
        $this->procedural = $procedural ?? [];

        return $this;
    }

    public function build(): Memory
    {
        $memory = new Memory();
        $memory->episodic = $this->episodic;
        $memory->declarative = $this->declarative;
        $memory->procedural = $this->procedural;

        return $memory;
    }
}