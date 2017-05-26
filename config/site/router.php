<?php

/**
 * Registering a router
 */
$di->set('router', function () use ($router)
{
    $router->setDefaultModule("site");

    $router->addGet('/:controller/:params', [
        'module' => 'site',
        'controller' => 'index',
        'action' => 'index',
        'params' => 2,
    ]);

    return $router;
});
