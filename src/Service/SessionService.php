<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionService
{
    // private $requestStack;
    
    // public function __construct(RequestStack $requestStack)
    // {
    //     $this->requestStack = $requestStack;
    // }

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getValue(string $key)
    {
        // return $this->requestStack->getSession()->get($value, null);
        return $this->session->get($key, null);
    }

    public function setValue(string $key, string $value)
    {
        // $this->requestStack->getSession()->set($attribute, $value);
        $this->session->set($key, $value);
    }
}
