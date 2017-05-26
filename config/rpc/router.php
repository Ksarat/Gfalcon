<?php

/**
 * Registering a router
 */
$di->set('router', function () use ($router)
{
    $router->setDefaultModule("rpc");

    $router->addGet('/', [
        'module' => 'rpc',
        'controller' => 'index',
        'action' => 'index',
    ]);


    return $router;
});