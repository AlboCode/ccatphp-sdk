<?php

namespace Albocode\CcatphpSdk\DTO;

class Why
{
    public ?string $input;

    /** @var null|array<string, mixed> */
    public ?array $intermediateSteps = [];

    public Memory $memory;

    /** @var null|array<string, mixed> */
    public ?array $modelInteractions = [];

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'input' => $this->input,
            'intermediate_steps' => $this->intermediateSteps,
            'memory' => $this->memory->toArray(),
            'model_interactions' => $this->modelInteractions,
        ];
    }
}
