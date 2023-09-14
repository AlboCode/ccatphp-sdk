<?php

namespace Albocode\CcatphpSdk\Model;

class Message
{
    public string $text;
    public string $user_id = '';

    public array $prompt_settings = [];

    /**
     * @param string $text
     * @param string $user_id
     */
    public function __construct(string $text, string $user_id = '', array $prompt_settings = [])
    {
        $this->text = $text;
        $this->user_id = $user_id;
        $this->prompt_settings = $prompt_settings;
    }


}