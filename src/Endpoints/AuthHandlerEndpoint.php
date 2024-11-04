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
     * This endpoint returns the settings of all the authentication handlers. It is used to get the settings of all the
     * authentication handlers that are available in the agent eventually specified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function getAuthHandlersSettings(?string $agentId = null): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            FactoryObjectSettingsOutput::class,
            $agentId,
        );
    }

    /**
     * This endpoint returns the settings of a specific authentication handler. It is used to get the settings of a
     * specific authentication handler that is available in the agent eventually specified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function getAuthHandlerSettings(string $authHandler, ?string $agentId = null): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $authHandler),
            FactoryObjectSettingOutput::class,
            $agentId,
        );
    }

    /**
     * This endpoint updates the settings of a specific authentication handler. It is used to update the settings of a
     * specific authentication handler that is available in the agent eventually specified by the agentId parameter.
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putAuthHandlerSettings(
        string $authHandler,
        array $values,
        ?string $agentId = null
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $authHandler),
            FactoryObjectSettingOutput::class,
            $values,
            $agentId,
        );
    }
}