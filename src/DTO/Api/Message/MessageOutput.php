<?php

namespace Albocode\CcatphpSdk\DTO\Api\Message;

use Albocode\CcatphpSdk\DTO\MessageBase;
use Albocode\CcatphpSdk\DTO\Why;

class MessageOutput extends MessageBase
{
    public ?string $type = 'chat';

    public Why $why;

    public ?bool $error = false;

    /** @deprecated */
    public readonly string $content;

    /**
     * @param string $text
     * @param array<int, string>|null $images
     * @param array<int, string>|null $audio
     */
    public function __construct(public string $text = '', public ?array $images = null, public ?array $audio = null)
    {
        $this->content = $text;
    }

    public function getContent(): string
    {
        return $this->text;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        $data['type'] = $this->type;
        $data['why'] = $this->why->toArray();
        $data['content'] = $this->text;
        $data['error'] = $this->error;

        return $data;
    }
}
