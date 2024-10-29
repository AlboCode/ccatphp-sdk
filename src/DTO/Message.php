<?php

namespace Albocode\CcatphpSdk\DTO;

class Message
{
    public string $text;
    public string $userId = 'user';
    public string $agentId = 'agent';

    /**
     * @var array<string, mixed>
     */
    public array $promptSettings = [];

    /**
     * @param array<string, mixed> $promptSettings
     */
    public function __construct(
        string $text, string $userId = 'user', string $agentId = 'agent', array $promptSettings = []
    ) {
        $this->text = $text;
        $this->userId = $userId;
        $this->agentId = $agentId;
        $this->promptSettings = $promptSettings;
    }
}
