<?php

namespace Albocode\CcatphpSdk\DTO\Api\Plugin;

class PluginCollectionOutput
{
    /** @var FilterOutput */
    public FilterOutput $filters;

    /** @var array<int, PluginItemOutput> */
    public array $installed = [];

    /** @var array<int, PluginItemRegistryOutput> */
    public array $registry = [];
}
