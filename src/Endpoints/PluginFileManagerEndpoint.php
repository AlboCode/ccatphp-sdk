<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingOutput;
use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingsOutput;
use Albocode\CcatphpSdk\DTO\SettingInput;
use GuzzleHttp\Exception\GuzzleException;

class PluginFileManagerEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/plugin_filemanager';

    /**
     * This endpoint returns the settings of all plugin file managers. Plugin file managers are set to a system level,
     * so usable by all the agents in the system.
     *
     * @throws GuzzleException
     */
    public function getPluginFileManagersSettings(): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            FactoryObjectSettingsOutput::class,
            $this->systemId,
        );
    }

    /**
     * This endpoint returns the settings of a specific plugin file manager. Plugin file managers are set to a system
     * level, so usable by all the agents in the system.
     *
     * @throws GuzzleException
     */
    public function getPluginFileManagerSettings(string $pluginFileManager): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $pluginFileManager),
            FactoryObjectSettingOutput::class,
            $this->systemId,
        );
    }

    /**
     * This endpoint updates the settings of a specific Plugin file manager. Plugin file managers are set to a system
     * level, so usable by all the agents in the system.
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putPluginFileManagerSettings(string $pluginFileManager, array $values): FactoryObjectSettingOutput
    {
        return $this->put(
            $this->formatUrl('/settings/' . $pluginFileManager),
            FactoryObjectSettingOutput::class,
            $values,
            $this->systemId,
        );
    }
}