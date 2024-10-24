<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingOutput;
use Albocode\CcatphpSdk\DTO\Api\Factory\FactoryObjectSettingsOutput;
use GuzzleHttp\Exception\GuzzleException;

class AuthHandlerEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/auth_handler';

    /**
     * @throws GuzzleException
     */
    public function getAuthHandlersSettings(
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
    public function getAuthHandlerSettings(
        string $authHandler,
        ?string $agentId = null,
        ?string $userId = null
    ): FactoryObjectSettingOutput {
        return $this->get(
            $this->formatUrl('/settings/' . $authHandler),
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
    public function putAuthHandlerSettings(
        string $authHandler,
        array $values,
        ?string $agentId = null,
        ?string $userId = null
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $authHandler),
            FactoryObjectSettingOutput::class,
            $values,
            $agentId,
            $userId,
        );
    }
}