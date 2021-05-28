<?php

namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;

class AppRunTime implements RuntimeExtensionInterface
{
    public function formatRs($value)
    {
        return '₹' . $value;
    }
}
