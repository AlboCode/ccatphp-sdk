<?php

namespace Albocode\CcatphpSdk\DTO\Api\Plugin;

class FilterOutput
{
    /** @var string|null */
    public ?string $query = null;

    /**
     * @return array<string, string|null>
     */
    public function toArray(): array
    {
        return [
            'query' => $this->query,
        ];
    }
}
