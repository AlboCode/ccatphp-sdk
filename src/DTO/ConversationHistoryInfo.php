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

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'who' => $this->who,
            'message' => $this->message,
            'why' => $this->why?->toArray(),
            'when' => $this->when,
            'role' => $this->role,
        ];
    }
}