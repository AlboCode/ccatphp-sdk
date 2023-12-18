<?php

namespace Albocode\CcatphpSdk\Model\Api\Plugin\Settings;

class PluginSchemaSettings
{
    public string $title;
    public string $type;
    /**
     * @var array<string, PropertySettingsOutput>
     */
    public array $properties;

}
