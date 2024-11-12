<?php

namespace Albocode\CcatphpSdk\DTO\Api\Message;

use Albocode\CcatphpSdk\DTO\MessageBase;
use Albocode\CcatphpSdk\DTO\Why;

class MessageOutput extends MessageBase
{
    public ?string $type = 'chat';

    public Why $why;
}
