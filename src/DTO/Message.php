<?php

namespace Albocode\CcatphpSdk\DTO;

class Message
{
    public string $text;

    /** @var string[]|null  */
    public ?array $images = [];

    /** @var string[]|null  */
    public ?array $audio = [];

    /**
     * @param string[]|null $images
     * @param string[]|null $audio
     */
    public function __construct(string $text, ?array $images = null, ?array $audio = null)
    {
        $this->text = $text;
        $this->images = $images;
        $this->audio = $audio;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = ['text' => $this->text];
        if ($this->images) {
            $result['images'] = $this->images;
        }
        if ($this->audio) {
            $result['audio'] = $this->audio;
        }

        return $result;
    }
}
