<?php

namespace App\Serializer;

use App\Entity\Post;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class PostSerializer implements SerializerInterface
{
    private $serializer;

    public function __construct(YamlEncoder $yamlEncoder, PostNormalizer $postNormalizer)
    {
        $encoders = [$yamlEncoder];
        $normalizers = [$postNormalizer];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function serialize($data, string $format = 'yaml', array $context = [])
    {
        return $this->serializer->serialize($data, $format, $context);
    }

    public function deserialize($data, string $type, string $format = 'yaml', array $context = [])
    {
        return $this->serializer->deserialize($data, $type, $format, $context);
    }
}
