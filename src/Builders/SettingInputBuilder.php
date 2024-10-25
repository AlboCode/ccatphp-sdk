<?php

namespace Albocode\CcatphpSdk\Builders;

use Albocode\CcatphpSdk\DTO\SettingInput;

class SettingInputBuilder implements BaseBuilder
{
    private string $name;

    /** @var array<string, mixed> */
    private array $value;

    private ?string $category;

    public static function create(): SettingInputBuilder
    {
        return new self();
    }

    public function setName(string $name): SettingInputBuilder
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param array<string, mixed> $value
     *
     * @return $this
     */
    public function setValue(array $value): SettingInputBuilder
    {
        $this->value = $value;
        return $this;
    }

    public function setCategory(string $category): SettingInputBuilder
    {
        $this->category = $category;
        return $this;
    }

    public function build(): SettingInput
    {
        return new SettingInput($this->name, $this->value, $this->category);
    }

}