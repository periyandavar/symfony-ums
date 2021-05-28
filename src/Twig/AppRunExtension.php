<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppRunExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('irupee', [AppRunTime::class, 'formatRs'])
        ];
    }
}
