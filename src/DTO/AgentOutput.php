<?php

namespace Albocode\CcatphpSdk\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class AgentOutput
{
    public ?string $output = null;

    /** @var null|array<string, mixed> */
    #[SerializedName('intermediate_steps')]
    public ?array $intermediateSteps = [];

    #[SerializedName('return_direct')]
    public bool $returnDirect = false;

    #[SerializedName('with_llm_error')]
    public bool $withLlmError = false;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'output' => $this->output,
            'intermediate_steps' => $this->intermediateSteps,
            'return_direct' => $this->returnDirect,
            'with_llm_error' => $this->withLlmError,
        ];
    }

}