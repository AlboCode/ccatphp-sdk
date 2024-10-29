<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingOutput;
use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingsOutput;
use Albocode\CcatphpSdk\DTO\SettingInput;
use GuzzleHttp\Exception\GuzzleException;

class PluginUploaderEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/plugin_uploader';

    /**
     * This endpoint returns the settings of all plugin uploader. Plugin uploaders are set to a system level, so usable
     * by all the agents in the system.
     *
     * @throws GuzzleException
     */
    public function getPluginUploadersSettings(): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            FactoryObjectSettingsOutput::class,
            $this->systemId,
        );
    }

    /**
     * This endpoint returns the settings of a specific plugin uploader. Plugin Uploaders are set to a system level, so
     * usable by all the agents in the system.
     *
     * @throws GuzzleException
     */
    public function getPluginUploaderSettings(string $pluginUploader): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $pluginUploader),
            FactoryObjectSettingOutput::class,
            $this->systemId,
        );
    }

    /**
     * This endpoint updates the settings of a specific Plugin Uploader. Plugin Uploaders are set to a system level, so
     * usable by all the agents in the system.
     *
     * @throws GuzzleException
     */
    public function putPluginUploaderSettings(string $pluginUploader, SettingInput $values): FactoryObjectSettingOutput
    {
        return $this->put(
            $this->formatUrl('/settings/' . $pluginUploader),
            FactoryObjectSettingOutput::class,
            $values->toArray(),
            $this->systemId,
        );
    }
}