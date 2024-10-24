<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginCollectionOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginDeleteOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginInstallFromRegistryOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginInstallOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginsSettingsOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginToggleOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\Settings\PluginSettingsOutput;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\ResponseInterface;

class PluginsEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/plugins';


    /**
     * @throws GuzzleException
     */
    public function getPlugins(
        ?string $query = null,
        ?string $agentId = null,
        ?string $userId = null,
    ): PluginCollectionOutput {
        return $this->get(
            $this->prefix,
            PluginCollectionOutput::class,
            $agentId,
            $userId,
            $query,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function installPluginFromZip(
        string $pathZip,
        ?string $agentId = null,
        ?string $userId = null,
    ): PluginInstallOutput{
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
            $userId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function installPluginFromRegistry(
        string $url,
        ?string $agentId = null,
        ?string $userId = null,
    ): PluginInstallFromRegistryOutput {
        return $this->postJson(
            $this->formatUrl('/upload/registry'),
            PluginInstallFromRegistryOutput::class,
            ['url' => $url],
            $agentId,
            $userId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function togglePlugin(
        string $pluginId,
        ?string $agentId = null,
        ?string $userId = null,
    ): PluginToggleOutput {
        return $this->put(
            $this->formatUrl('/toggle/' . $pluginId),
            PluginToggleOutput::class,
            [],
            $agentId,
            $userId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getPluginsSettings(
        ?string $agentId = null,
        ?string $userId = null,
    ): PluginSettingsOutput {
        return $this->get(
            $this->formatUrl('/settings'),
            PluginsSettingsOutput::class,
            $agentId,
            $userId,
        );
    }

    /**
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function getPluginSettings(
        string $pluginId,
        array $values,
        ?string $agentId = null,
        ?string $userId = null,
    ): PluginSettingsOutput {
        return $this->get(
            $this->formatUrl('/settings/' . $pluginId),
            PluginSettingsOutput::class,
            $agentId,
            $userId,
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
        ?string $userId = null,
    ): PluginSettingsOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $pluginId),
            PluginSettingsOutput::class,
            $values,
            $agentId,
            $userId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getPluginDetails(
        string $pluginId,
        ?string $agentId = null,
        ?string $userId = null,
    ): PluginSettingsOutput {
        return $this->get(
            $this->formatUrl($pluginId),
            PluginSettingsOutput::class,
            $agentId,
            $userId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function deletePlugin(
        string $pluginId,
        ?string $agentId = null,
        ?string $userId = null,
    ): ResponseInterface {
        return $this->delete(
            $this->formatUrl($pluginId),
            PluginDeleteOutput::class,
            $agentId,
            $userId,
        );
    }
}