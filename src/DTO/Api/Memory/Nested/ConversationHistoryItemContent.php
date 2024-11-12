<?php

namespace Albocode\CcatphpSdk\DTO\Api\Memory\Nested;

use Albocode\CcatphpSdk\DTO\MessageBase;
use Albocode\CcatphpSdk\DTO\Why;

class ConversationHistoryItemContent extends MessageBase
{
    public string $text;

    /** @var string[]|null  */
    public ?array $images = [];

    /** @var string[]|null  */
    public ?array $audio = [];

    /** @var Why|null */
    public ?Why $why = null;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if ($this->why !== null) {
            $data['why'] = $this->why->toArray();
        }

        return $data;
    }
}