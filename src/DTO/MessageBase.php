<?php

namespace Albocode\CcatphpSdk\DTO;

class MessageBase
{
    public string $text;

    /** @var string[]|null  */
    public ?array $images = [];

    /** @var string[]|null  */
    public ?array $audio = [];
}