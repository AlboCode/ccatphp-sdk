<?php

namespace Albocode\CcatphpSdk\DTO\Api\Factory;

class FactoryObjectSettingOutput
{
    public string $name;

    /** @var array<string, mixed> */
    public array $value;

    /** @var array<string, mixed>|null */
    public ?array $scheme = null;
}
