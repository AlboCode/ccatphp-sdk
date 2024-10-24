<?php

namespace Albocode\CcatphpSdk\DTO;

class ConversationHistoryInfo
{
    public string $who;

    public string $message;

    /** @var Why|null */
    public ?Why $why = null;

    public float $when;

    public string $role;
}