<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingOutput;
use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingsOutput;
use Albocode\CcatphpSdk\DTO\SettingInput;
use GuzzleHttp\Exception\GuzzleException;

class EmbedderEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/embedder';

    /**
     * @throws GuzzleException
     */
    public function getEmbeddersSettings(?string $loggedAdminId = null): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            FactoryObjectSettingsOutput::class,
            $this->systemId,
            $loggedAdminId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getEmbedderSettings(string $embedder, ?string $loggedAdminId = null): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $embedder),
            FactoryObjectSettingOutput::class,
            $this->systemId,
            $loggedAdminId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function putEmbedderSettings(
        string $embedder,
        SettingInput $values,
        ?string $loggedAdminId = null
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $embedder),
            FactoryObjectSettingOutput::class,
            $values->toArray(),
            $this->systemId,
            $loggedAdminId,
        );
    }
}