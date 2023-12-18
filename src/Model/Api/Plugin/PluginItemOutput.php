<?php

namespace Albocode\CcatphpSdk\Model\Api\Plugin;

class PluginItemOutput
{
    public string $id;

    public string $name;

    public string $description;

    public string $authorName;

    public string $authorUrl;

    public string $pluginUrl;

    public string $tags;

    public string $thumb;

    public string $version;

    public bool $active;

    /**
     * @var array<int, HookOutput>
     */
    public array $hooks;

    /**
     * @var array<int, ToolOutput>
     */
    public array $tools;

}
