<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingOutput;
use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingsOutput;
use Albocode\CcatphpSdk\DTO\SettingInput;
use GuzzleHttp\Exception\GuzzleException;

class LargeLanguageModelEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/llm';

    /**
     * This endpoint returns the settings of all large language models, either for the agent identified by the agentId
     * parameter (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function getLargeLanguageModelsSettings(?string $agentId = null): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            FactoryObjectSettingsOutput::class,
            $agentId,
        );
    }

    /**
     * This endpoint returns the settings of a specific large language model, either for the agent identified by the
     * agentId parameter (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function getLargeLanguageModelSettings(string $llm, ?string $agentId = null): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $llm),
            FactoryObjectSettingOutput::class,
            $agentId,
        );
    }

    /**
     * This endpoint updates the settings of a specific large language model, either for the agent identified by the
     * agentId parameter (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putLargeLanguageModelSettings(
        string $llm,
        array $values,
        ?string $agentId = null,
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $llm),
            FactoryObjectSettingOutput::class,
            $values,
            $agentId,
        );
    }
}