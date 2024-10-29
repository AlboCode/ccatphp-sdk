<?php

namespace Albocode\CcatphpSdk\DTO\Api\Plugin\Settings;

class PluginSettingsOutput
{
    public string $name;

    /** @var PluginSchemaSettings|null */
    public ?PluginSchemaSettings $scheme = null;

    /** @var array<string, mixed> */
    public array $value;
}
