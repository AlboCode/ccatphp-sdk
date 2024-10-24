<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Setting\SettingDeleteOutput;
use Albocode\CcatphpSdk\DTO\Api\Setting\SettingOutputItem;
use Albocode\CcatphpSdk\DTO\Api\Setting\SettingsOutputCollection;
use GuzzleHttp\Exception\GuzzleException;

class SettingsEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/settings';

    /**
     * @throws GuzzleException
     */
    public function getSettings(?string $agentId = null, ?string $userId = null): SettingsOutputCollection
    {
        return $this->get($this->prefix, SettingsOutputCollection::class, $agentId, $userId);
    }

    /**
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function postSetting(array $values, ?string $agentId = null, ?string $userId = null): SettingOutputItem
    {
        return $this->postJson(
            $this->prefix,
            SettingOutputItem::class,
            $values,
            $agentId,
            $userId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getSetting(string $settingId, ?string $agentId = null, ?string $userId = null): SettingOutputItem
    {
        return $this->get(
            $this->formatUrl($settingId),
            SettingOutputItem::class,
            $agentId,
            $userId,
        );
    }

    /**
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putSetting(
        string $settingId,
        array $values,
        ?string $agentId = null,
        ?string $userId = null,
    ): SettingOutputItem {
        return $this->put(
            $this->formatUrl($settingId),
            SettingOutputItem::class,
            $values,
            $agentId,
            $userId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function deleteSetting(
        string $settingId,
        ?string $agentId = null,
        ?string $userId = null
    ): SettingDeleteOutput {
        return $this->delete(
            $this->formatUrl($settingId),
            SettingDeleteOutput::class,
            $agentId,
            $userId,
        );
    }
}