<?php

namespace Albocode\CcatphpSdk\Model\Api\Plugin;

class PluginCollectionOutput
{
    /**
     * @var FilterOutput
     */
    public FilterOutput $filters;

    /**
     * @var array<int, PluginItemOutput>
     */
    public array $installed = [];

    /**
     * @var array<int, PluginItemRegistryOutput>
     */
    public array $registry = [];


}
