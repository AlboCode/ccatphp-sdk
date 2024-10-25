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

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'filters' => $this->filters->toArray(),
            'installed' => array_map(fn(PluginItemOutput $item) => $item->toArray(), $this->installed),
            'registry' => array_map(fn(PluginItemRegistryOutput $item) => $item->toArray(), $this->registry),
        ];
    }
}
