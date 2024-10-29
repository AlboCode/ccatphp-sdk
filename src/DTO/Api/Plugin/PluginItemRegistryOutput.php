<?php

namespace Albocode\CcatphpSdk\DTO\Api\Plugin;

class PluginItemRegistryOutput
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

    public string $url;

    /**
     * @return array<string, string>
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
            'url' => $this->url,
        ];
    }
}
