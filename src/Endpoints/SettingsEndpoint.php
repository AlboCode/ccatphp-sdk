<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Setting\SettingDeleteOutput;
use Albocode\CcatphpSdk\DTO\Api\Setting\SettingOutputItem;
use Albocode\CcatphpSdk\DTO\Api\Setting\SettingsOutputCollection;
use Albocode\CcatphpSdk\DTO\SettingInput;
use GuzzleHttp\Exception\GuzzleException;

class SettingsEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/settings';

    /**
     * @throws GuzzleException
     */
    public function getSettings(?string $agentId = null, ?string $loggedUserId = null): SettingsOutputCollection
    {
        return $this->get($this->prefix, SettingsOutputCollection::class, $agentId, $loggedUserId);
    }

    /**
     * @throws GuzzleException
     */
    public function postSetting(
        SettingInput $values,
        ?string $agentId = null,
        ?string $loggedUserId = null
    ): SettingOutputItem {
        return $this->postJson(
            $this->prefix,
            SettingOutputItem::class,
            $values->toArray(),
            $agentId,
            $loggedUserId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getSetting(
        string $settingId,
        ?string $agentId = null,
        ?string $loggedUserId = null
    ): SettingOutputItem {
        return $this->get(
            $this->formatUrl($settingId),
            SettingOutputItem::class,
            $agentId,
            $loggedUserId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function putSetting(
        string $settingId,
        SettingInput $values,
        ?string $agentId = null,
        ?string $loggedUserId = null,
    ): SettingOutputItem {
        return $this->put(
            $this->formatUrl($settingId),
            SettingOutputItem::class,
            $values->toArray(),
            $agentId,
            $loggedUserId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function deleteSetting(
        string $settingId,
        ?string $agentId = null,
        ?string $loggedUserId = null
    ): SettingDeleteOutput {
        return $this->delete(
            $this->formatUrl($settingId),
            SettingDeleteOutput::class,
            $agentId,
            $loggedUserId,
        );
    }
}