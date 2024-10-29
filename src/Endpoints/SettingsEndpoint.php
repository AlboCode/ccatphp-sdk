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
     * This endpoint returns the settings of the agent identified by the agentId parameter (multi-agent installations)
     * You can omit the agentId parameter in a single-agent installation. In this case, the settings of the default
     * agent are returned.
     *
     * @throws GuzzleException
     */
    public function getSettings(?string $agentId = null): SettingsOutputCollection
    {
        return $this->get($this->prefix, SettingsOutputCollection::class, $agentId);
    }

    /**
     * This method creates a new setting for the agent identified by the agentId parameter (multi-agent installations).
     * You can omit the agentId parameter in a single-agent installation. In this case, the setting is created for the
     * default agent.
     *
     * @throws GuzzleException
     */
    public function postSetting(SettingInput $values, ?string $agentId = null): SettingOutputItem
    {
        return $this->postJson(
            $this->prefix,
            SettingOutputItem::class,
            $values->toArray(),
            $agentId,
        );
    }

    /**
     * This endpoint returns the setting identified by the settingId parameter. The setting must belong to the agent
     * identified by the agentId parameter (multi-agent installations). You can omit the agentId parameter in a
     * single-agent installation. In this case, the setting is looked up in the default agent.
     *
     * @throws GuzzleException
     */
    public function getSetting(string $settingId, ?string $agentId = null): SettingOutputItem
    {
        return $this->get(
            $this->formatUrl($settingId),
            SettingOutputItem::class,
            $agentId,
        );
    }

    /**
     * This method updates the setting identified by the settingId parameter. The setting must belong to the agent
     * identified by the agentId parameter (multi-agent installations). You can omit the agentId parameter in a
     * single-agent installation. In this case, the setting is updated in the default agent.
     *
     * @throws GuzzleException
     */
    public function putSetting(string $settingId, SettingInput $values, ?string $agentId = null): SettingOutputItem
    {
        return $this->put(
            $this->formatUrl($settingId),
            SettingOutputItem::class,
            $values->toArray(),
            $agentId,
        );
    }

    /**
     * This endpoint deletes the setting identified by the settingId parameter. The setting must belong to the agent
     * identified by the agentId parameter (multi-agent installations). You can omit the agentId parameter in a
     * single-agent installation. In this case, the setting is deleted from the default agent.
     *
     * @throws GuzzleException
     */
    public function deleteSetting(string $settingId, ?string $agentId = null): SettingDeleteOutput
    {
        return $this->delete(
            $this->formatUrl($settingId),
            SettingDeleteOutput::class,
            $agentId,
        );
    }
}