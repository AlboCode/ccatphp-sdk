<?php

namespace Albocode\CcatphpSdk\DTO\Api\Message;

use Albocode\CcatphpSdk\DTO\MessageBase;
use Albocode\CcatphpSdk\DTO\Why;

class MessageOutput extends MessageBase
{
    public ?string $type = 'chat';

    public Why $why;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        $data['type'] = $this->type;
        $data['why'] = $this->why->toArray();

        return $data;
    }
}
