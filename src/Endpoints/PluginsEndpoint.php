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
     * @throws GuzzleException
     */
    public function getAvailablePlugins(
        ?string $query = null,
        ?string $agentId = null,
        ?string $loggedUserId = null,
    ): PluginCollectionOutput {
        return $this->get(
            $this->prefix,
            PluginCollectionOutput::class,
            $agentId,
            $loggedUserId,
            $query,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function installPluginFromZip(
        string $pathZip,
        ?string $agentId = null,
        ?string $loggedUserId = null,
    ): PluginInstallOutput {
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
            $loggedUserId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function installPluginFromRegistry(
        string $url,
        ?string $agentId = null,
        ?string $loggedUserId = null,
    ): PluginInstallFromRegistryOutput {
        return $this->postJson(
            $this->formatUrl('/upload/registry'),
            PluginInstallFromRegistryOutput::class,
            ['url' => $url],
            $agentId,
            $loggedUserId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function togglePlugin(
        string $pluginId,
        ?string $agentId = null,
        ?string $loggedUserId = null,
    ): PluginToggleOutput {
        return $this->put(
            $this->formatUrl('/toggle/' . $pluginId),
            PluginToggleOutput::class,
            [],
            $agentId,
            $loggedUserId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getPluginsSettings(
        ?string $agentId = null,
        ?string $loggedUserId = null,
    ): PluginsSettingsOutput {
        return $this->get(
            $this->formatUrl('/settings'),
            PluginsSettingsOutput::class,
            $agentId,
            $loggedUserId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getPluginSettings(
        string $pluginId,
        ?string $agentId = null,
        ?string $loggedUserId = null,
    ): PluginSettingsOutput {
        return $this->get(
            $this->formatUrl('/settings/' . $pluginId),
            PluginSettingsOutput::class,
            $agentId,
            $loggedUserId,
        );
    }

    /**
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putPluginSettings(
        string $pluginId,
        array $values,
        ?string $agentId = null,
        ?string $loggedUserId = null,
    ): PluginSettingsOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $pluginId),
            PluginSettingsOutput::class,
            $values,
            $agentId,
            $loggedUserId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getPluginDetails(
        string $pluginId,
        ?string $agentId = null,
        ?string $loggedUserId = null,
    ): PluginDetailsOutput {
        return $this->get(
            $this->formatUrl($pluginId),
            PluginDetailsOutput::class,
            $agentId,
            $loggedUserId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function deletePlugin(
        string $pluginId,
        ?string $agentId = null,
        ?string $loggedUserId = null,
    ): PluginDeleteOutput {
        return $this->delete(
            $this->formatUrl($pluginId),
            PluginDeleteOutput::class,
            $agentId,
            $loggedUserId,
        );
    }
}