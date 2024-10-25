<?php

namespace Albocode\CcatphpSdk\DTO;

class SettingInput
{
    public string $name;

    /** @var array<string, mixed> */
    public array $value;

    public ?string $category;

    /**
     * @param array<string, mixed> $value
     */
    public function __construct(string $name, array $value, ?string $category = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->category = $category;
    }

    /**
     * @return array<string, mixed> $value
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
            'category' => $this->category,
        ];
    }
}
