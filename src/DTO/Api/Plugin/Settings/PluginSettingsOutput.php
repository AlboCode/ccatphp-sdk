<?php

namespace Albocode\CcatphpSdk\DTO\Api\Plugin\Settings;

class PluginSettingsOutput
{
    public string $name;

    /** @var PluginSchemaSettings */
    public PluginSchemaSettings $scheme;

    /** @var array<string, mixed> */
    public array $value;
}
