<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('somedir')
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@Symfony' => true,
        'full_opening_tag' => false,
    ])
    ->setFinder($finder)
;