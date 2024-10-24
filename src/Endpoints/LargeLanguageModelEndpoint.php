<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingOutput;
use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingsOutput;
use GuzzleHttp\Exception\GuzzleException;

class LargeLanguageModelEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/llm';


    /**
     * @throws GuzzleException
     */
    public function getLargeLanguageModelsSettings(
        ?string $agentId = null,
        ?string $userId = null
    ): FactoryObjectSettingsOutput {
        return $this->get(
            $this->formatUrl('/settings'),
            FactoryObjectSettingsOutput::class,
            $agentId,
            $userId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getLargeLanguageModelSettings(
        string $llm,
        ?string $agentId = null,
        ?string $userId = null
    ): FactoryObjectSettingOutput {
        return $this->get(
            $this->formatUrl('/settings/' . $llm),
            FactoryObjectSettingOutput::class,
            $agentId,
            $userId,
        );
    }

    /**
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putLargeLanguageModelSettings(
        string $llm,
        array $values,
        ?string $agentId = null,
        ?string $userId = null
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $llm),
            FactoryObjectSettingOutput::class,
            $values,
            $agentId,
            $userId,
        );
    }
}