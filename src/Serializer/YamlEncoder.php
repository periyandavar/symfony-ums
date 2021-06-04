<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Yaml\Yaml;

class YamlEncoder implements EncoderInterface, DecoderInterface
{
    public function encode($data, string $format, array $context = [])
    {
        return Yaml::dump($data);
    }

    public function supportsEncoding(string $format)
    {
        return 'yaml' === $format;
    }

    public function decode($data, string $format, array $context = [])
    {
        return Yaml::parse($data);
    }

    public function supportsDecoding(string $format)
    {
        return 'yaml' === $format;
    }
}
