<?php

namespace App\Processor;

use Symfony\Component\DependencyInjection\EnvVarProcessorInterface;

class LowercasingEnvVarProcessor implements EnvVarProcessorInterface
{
    public function getEnv(string $prefix, string $name, \Closure $getEnv)
    {
        $env = $getEnv($name);
        return strtolower($env);
    }

    public static function getProvidedTypes()
    {
        return [
            'lowercase' => 'string'
        ];
    }
}
