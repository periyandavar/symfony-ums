<?php

namespace App\Mime;

use Symfony\Component\Mime\MimeTypeGuesserInterface;

class SomeMimeTypeGuesser implements MimeTypeGuesserInterface
{
    public function isGuesserSupported(): bool
    {
        return true;
    }

    public function guessMimeType(string $path): ?string
    {
        $ext = '.png';
        $len = strlen($ext);
        if (substr($path, -$len) == $ext) {
            return 'image/png';
        }

        return null;
    }
}
