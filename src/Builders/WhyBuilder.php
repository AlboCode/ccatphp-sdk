<?php

namespace Albocode\CcatphpSdk\Builders;

use Albocode\CcatphpSdk\DTO\AgentOutput;
use Albocode\CcatphpSdk\DTO\Memory;
use Albocode\CcatphpSdk\DTO\Why;

class WhyBuilder implements BaseBuilder
{
    private ?string $input;

    /** @var null|array<string, mixed> */
    private ?array $intermediateSteps = [];

    private Memory $memory;

    /** @var null|array<string, mixed> */

    private ?array $modelInteractions = [];

    private ?AgentOutput $agentOutput = null;

    public static function create() : WhyBuilder
    {
        return new self();
    }

    public function setInput(?string $input): WhyBuilder
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @param array<string, mixed> $intermediateSteps
     */
    public function setIntermediateSteps(?array $intermediateSteps = null): WhyBuilder
    {
        $this->intermediateSteps = $intermediateSteps ?? [];

        return $this;
    }

    public function setMemory(Memory $memory): WhyBuilder
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * @param array<string, mixed> $modelInteractions
     */
    public function setModelInteractions(?array $modelInteractions = null): WhyBuilder
    {
        $this->modelInteractions = $modelInteractions ?? [];

        return $this;
    }

    public function setAgentOutput(?AgentOutput $agentOutput = null): WhyBuilder
    {
        $this->agentOutput = $agentOutput;

        return $this;
    }

    public function build(): Why
    {
        $why = new Why();
        $why->input = $this->input;
        $why->intermediateSteps = $this->intermediateSteps;
        $why->memory = $this->memory;
        $why->modelInteractions = $this->modelInteractions;
        $why->agentOutput = $this->agentOutput;

        return $why;
    }
}