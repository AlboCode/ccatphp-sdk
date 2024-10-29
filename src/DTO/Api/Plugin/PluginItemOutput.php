<?php

namespace Albocode\CcatphpSdk\DTO\Api\Plugin;

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

    /** @var array<int, HookOutput> */
    public array $hooks;

    /** @var array<int, ToolOutput> */
    public array $tools;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'author_name' => $this->authorName,
            'author_url' => $this->authorUrl,
            'plugin_url' => $this->pluginUrl,
            'tags' => $this->tags,
            'thumb' => $this->thumb,
            'version' => $this->version,
            'active' => $this->active,
            'hooks' => array_map(fn(HookOutput $item) => $item->toArray(), $this->hooks),
            'tools' => array_map(fn(ToolOutput $item) => $item->toArray(), $this->tools),
        ];
    }
}
