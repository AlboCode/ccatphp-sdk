<?php

namespace Albocode\CcatphpSdk\Model;

class Why
{
    public ?string $input;

    /**
     * @var null|array<string, mixed>
     */
    public ?array $intermediate_steps;

    public Memory $memory;
    /**
     * @var null|array<mixed>
     */
    public ?array $model_interactions = null;
}
