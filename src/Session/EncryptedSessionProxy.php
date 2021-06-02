<?php

namespace App\Session;

use Defuse\Crypto\Crypto;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\SessionHandlerProxy;
use Defuse\Crypto\Key;

class EncryptedSessionProxy extends SessionHandlerProxy
{
    private $key;

    public function __construct(\SessionHandlerInterface $handler, Key $key)
    {
        $this->key = $key;
        parent::__construct($handler);
    }

    public function read($id)
    {
        $data = parent::read($id);
        return Crypto::decrypt($data, $this->key);
    }

    public function write($id, $data)
    {
        $data = Crypto::encrypt($data, $this->key);
        return parent::write($id, $data);
    }
}

