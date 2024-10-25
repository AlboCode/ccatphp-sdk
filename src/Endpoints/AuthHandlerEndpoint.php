<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingOutput;
use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingsOutput;
use Albocode\CcatphpSdk\DTO\SettingInput;
use GuzzleHttp\Exception\GuzzleException;

class AuthHandlerEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/auth_handler';

    /**
     * @throws GuzzleException
     */
    public function getAuthHandlersSettings(
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
    public function getAuthHandlerSettings(
        string $authHandler,
        ?string $agentId = null,
        ?string $loggedUserId = null
    ): FactoryObjectSettingOutput {
        return $this->get(
            $this->formatUrl('/settings/' . $authHandler),
            FactoryObjectSettingOutput::class,
            $agentId,
            $loggedUserId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function putAuthHandlerSettings(
        string $authHandler,
        SettingInput $values,
        ?string $agentId = null,
        ?string $loggedUserId = null
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $authHandler),
            FactoryObjectSettingOutput::class,
            $values->toArray(),
            $agentId,
            $loggedUserId,
        );
    }
}