<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginCollectionOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginDeleteOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginDetailsOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginInstallFromRegistryOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginInstallOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginsSettingsOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginToggleOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\Settings\PluginSettingsOutput;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Utils;

class PluginsEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/plugins';

    /**
     * This endpoint returns the available plugins, either for the agent identified by the agentId parameter
     * (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function getAvailablePlugins(?string $query = null, ?string $agentId = null): PluginCollectionOutput
    {
        return $this->get(
            $this->prefix,
            PluginCollectionOutput::class,
            $agentId,
            null,
            $query,
        );
    }

    /**
     * This endpoint installs a plugin from a ZIP file, either for the agent identified by the agentId parameter
     * (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function installPluginFromZip(string $pathZip, ?string $agentId = null): PluginInstallOutput
    {
        return $this->postMultipart(
            $this->formatUrl('/upload'),
            PluginInstallOutput::class,
            [
                [
                    'name' => 'file',
                    'contents' => Utils::tryFopen($pathZip, 'r'),
                    'filename' => basename($pathZip),
                ],
            ],
            $agentId,
        );
    }

    /**
     * This endpoint installs a plugin from the registry, either for the agent identified by the agentId parameter
     * (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function installPluginFromRegistry(string $url, ?string $agentId = null): PluginInstallFromRegistryOutput
    {
        return $this->postJson(
            $this->formatUrl('/upload/registry'),
            PluginInstallFromRegistryOutput::class,
            ['url' => $url],
            $agentId,
        );
    }

    /**
     * This endpoint toggles a plugin, either for the agent identified by the agentId parameter (for multi-agent
     * installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function togglePlugin(string $pluginId, ?string $agentId = null): PluginToggleOutput
    {
        return $this->put(
            $this->formatUrl('/toggle/' . $pluginId),
            PluginToggleOutput::class,
            [],
            $agentId,
        );
    }

    /**
     * This endpoint retrieves the plugins settings, either for the agent identified by the agentId parameter
     * (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function getPluginsSettings(?string $agentId = null): PluginsSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            PluginsSettingsOutput::class,
            $agentId,
        );
    }

    /**
     * This endpoint retrieves the plugin settings, either for the agent identified by the agentId parameter
     * (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function getPluginSettings(string $pluginId, ?string $agentId = null): PluginSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $pluginId),
            PluginSettingsOutput::class,
            $agentId,
        );
    }

    /**
     * This endpoint updates the plugin settings, either for the agent identified by the agentId parameter
     * (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putPluginSettings(string $pluginId, array $values, ?string $agentId = null): PluginSettingsOutput
    {
        return $this->put(
            $this->formatUrl('/settings/' . $pluginId),
            PluginSettingsOutput::class,
            $values,
            $agentId,
        );
    }

    /**
     * This endpoint retrieves the plugin details, either for the agent identified by the agentId parameter
     * (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function getPluginDetails(string $pluginId, ?string $agentId = null): PluginDetailsOutput
    {
        return $this->get(
            $this->formatUrl($pluginId),
            PluginDetailsOutput::class,
            $agentId,
        );
    }

    /**
     * This endpoint deletes a plugin, either for the agent identified by the agentId parameter (for multi-agent
     * installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function deletePlugin(string $pluginId, ?string $agentId = null): PluginDeleteOutput
    {
        return $this->delete(
            $this->formatUrl($pluginId),
            PluginDeleteOutput::class,
            $agentId,
        );
    }
}