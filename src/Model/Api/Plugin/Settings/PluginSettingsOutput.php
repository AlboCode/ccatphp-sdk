<?php

namespace Albocode\CcatphpSdk\Model\Api\Plugin\Settings;

class PluginSettingsOutput
{
    public string $name;

    /**
     * @var PluginSchemaSettings
     */
    public PluginSchemaSettings $schema;

    /**
     * @var array<string, mixed>
     */
    public array $value;
}
