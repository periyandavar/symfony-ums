<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class MessageGenerator
{

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    /**
     * Returns the random message
     *
     * @return string
     */
    public function generateMessage(): string
    {
        $request = $this->requestStack->getCurrentRequest();
        $messages = ['welcome', 'good', 'cool'];
        return $messages[array_rand($messages)] . ' ' . $request->attributes->get('value');
    }
}
