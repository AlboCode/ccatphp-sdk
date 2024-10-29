<?php

namespace Albocode\CcatphpSdk\DTO\Api\Admins;

use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginToggleOutput;

class PluginInstallFromRegistryOutput extends PluginToggleOutput
{
    public string $url;

    public string $info;
}