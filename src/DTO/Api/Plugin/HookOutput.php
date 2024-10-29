<?php

namespace Albocode\CcatphpSdk\DTO\Api\Plugin;

class HookOutput
{
    public string $name;

    public int $priority;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'priority' => $this->priority,
        ];
    }
}
