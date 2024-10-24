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
}
