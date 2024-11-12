<?php

namespace Albocode\CcatphpSdk\DTO;

class MessageBase
{
    public string $text;

    /** @var string[]|null  */
    public ?array $images = [];

    /** @var string[]|null  */
    public ?array $audio = [];

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [
            'text' => $this->text,
        ];

        if ($this->images !== null) {
            $result['images'] = $this->images;
        }

        if ($this->audio !== null) {
            $result['audio'] = $this->audio;
        }

        return $result;
    }
}