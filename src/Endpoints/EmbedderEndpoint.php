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
     * This endpoint returns the settings of all embedders. Embedders are set to a system level, so usable by all
     * the agents in the system.
     *
     * @throws GuzzleException
     */
    public function getEmbeddersSettings(): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            FactoryObjectSettingsOutput::class,
            $this->systemId,
        );
    }

    /**
     * This endpoint returns the settings of a specific embedder. Embedders are set to a system level, so usable by all
     * the agents in the system.
     *
     * @throws GuzzleException
     */
    public function getEmbedderSettings(string $embedder): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $embedder),
            FactoryObjectSettingOutput::class,
            $this->systemId,
        );
    }

    /**
     * This endpoint updates the settings of a specific embedder. Embedders are set to a system level, so usable by all
     * the agents in the system.
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putEmbedderSettings(string $embedder, array $values): FactoryObjectSettingOutput
    {
        return $this->put(
            $this->formatUrl('/settings/' . $embedder),
            FactoryObjectSettingOutput::class,
            $values,
            $this->systemId,
        );
    }
}