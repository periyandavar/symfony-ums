<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    /**
     * Name of the directory to store uploaded file.
     *
     * @var string
     */
    private $destination;

    public function __construct(string $destination)
    {
        $this->destination = $destination;
    }

    public function upload(UploadedFile $file)
    {
        if ($file) {
            $fname = uniqid() . '.' . $file->guessExtension();
            try {
                $file->move($this->destination, $fname);
            } catch (FileException $e) {
                return false;
            }

            return $fname;
        }
    }
}
