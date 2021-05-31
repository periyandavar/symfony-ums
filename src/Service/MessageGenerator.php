<?php

namespace App\Service;

class MessageGenerator
{
    /**
     * Returns the random message
     *
     * @return string
     */
    public function generateMessage(): string
    {
        $messages = ['welcome', 'good', 'cool'];
        return $messages[array_rand($messages)];
    }
}
