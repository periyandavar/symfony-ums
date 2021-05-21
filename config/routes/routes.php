<?php

use App\Controller\IndexController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('phps', "/phps")
        ->controller([IndexController::class, 'php'])
        ->methods(['GET', 'POST']);
    $routes->add('php', "/php/{param}")
        ->controller([IndexController::class, 'param'])
        ->requirements(['param' => '\d+'])
        ->defaults(['param' => 2])
        ->stateless();
};
