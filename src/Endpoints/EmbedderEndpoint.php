<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingOutput;
use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingsOutput;
use GuzzleHttp\Exception\GuzzleException;

class EmbedderEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/embedder';

    /**
     * @throws GuzzleException
     */
    public function getEmbeddersSettings(?string $adminId = null): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            FactoryObjectSettingsOutput::class,
            $this->systemId,
            $adminId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getEmbedderSettings(string $embedder, ?string $adminId = null): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $embedder),
            FactoryObjectSettingOutput::class,
            $this->systemId,
            $adminId,
        );
    }

    /**
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putEmbedderSettings(
        string $embedder,
        array $values,
        ?string $adminId = null
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $embedder),
            FactoryObjectSettingOutput::class,
            $values,
            $this->systemId,
            $adminId,
        );
    }
}