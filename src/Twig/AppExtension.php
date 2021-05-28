<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function formatRs($value)
    {
        return '₹' . $value;
    }

    public function square($value)
    {
        return $value * $value;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('rupee', [$this, 'formatRs'])
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('square', [$this, 'square'])
        ];
    }
}
