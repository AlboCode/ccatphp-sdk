<?php

namespace Albocode\CcatphpSdk\DTO;

class Message extends MessageBase
{
    /**
     * @var array<string, mixed>|null
     */
    public ?array $additionalFields;

    /**
     * @param string[]|null $images
     * @param string[]|null $audio
     * @param array<string, mixed>|null $additionalFields
     */
    public function __construct(
        string $text,
        ?array $images = null,
        ?array $audio = null,
        ?array $additionalFields = null
    ) {
        $this->text = $text;
        $this->images = $images;
        $this->audio = $audio;
        $this->additionalFields = $additionalFields;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [
            'text' => $this->text,
            'images' => $this->images,
            'audio' => $this->audio,
        ];

        if ($this->additionalFields !== null) {
            $result = array_merge($result, $this->additionalFields);
        }

        return $result;
    }
}
