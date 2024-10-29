<?php

namespace Albocode\CcatphpSdk\DTO\Api\Setting;

class SettingOutput
{
    public string $name;

    /** @var array<string, mixed> */
    public array $value;

    public string $category;

    public string $settingId;

    public int $updatedAt;
}
