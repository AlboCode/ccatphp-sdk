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
     * @throws GuzzleException
     */
    public function getLargeLanguageModelsSettings(
        ?string $agentId = null,
        ?string $loggedUserId = null
    ): FactoryObjectSettingsOutput {
        return $this->get(
            $this->formatUrl('/settings'),
            FactoryObjectSettingsOutput::class,
            $agentId,
            $loggedUserId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getLargeLanguageModelSettings(
        string $llm,
        ?string $agentId = null,
        ?string $loggedUserId = null
    ): FactoryObjectSettingOutput {
        return $this->get(
            $this->formatUrl('/settings/' . $llm),
            FactoryObjectSettingOutput::class,
            $agentId,
            $loggedUserId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function putLargeLanguageModelSettings(
        string $llm,
        SettingInput $values,
        ?string $agentId = null,
        ?string $loggedUserId = null
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $llm),
            FactoryObjectSettingOutput::class,
            $values->toArray(),
            $agentId,
            $loggedUserId,
        );
    }
}