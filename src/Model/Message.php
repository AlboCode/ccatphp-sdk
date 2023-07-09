<?php

namespace Albocode\CcatphpSdk\Model;

class Message
{
    public string $text;
    public string $user_id = '';

    /**
     * @param string $text
     * @param string $user_id
     */
    public function __construct(string $text, string $user_id = '')
    {
        $this->text = $text;
        $this->user_id = $user_id;
    }


}