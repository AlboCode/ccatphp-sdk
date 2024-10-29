<?php

namespace Albocode\CcatphpSdk\DTO\Api\Admins;

use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginToggleOutput;

class PluginInstallOutput extends PluginToggleOutput
{
    public string $filename;
    public string $contentType;
}