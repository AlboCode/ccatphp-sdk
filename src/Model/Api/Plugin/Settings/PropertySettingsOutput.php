<?php

namespace Albocode\CcatphpSdk\Model\Api\Plugin\Settings;

class PropertySettingsOutput
{
    public string $default;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $extra = null;

    public string $title;

    public string $type;

}
