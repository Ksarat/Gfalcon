<?php

use Phalcon\Mvc\Application;

define('APP_PATH', 'rpc');

require(__DIR__ . '/../cbootstrap/cconfig.php');

$application = new Application($di);

$application->registerModules([
    'rpc' => [
        'className' => 'JsonRPC\Module',
        'path' => '../apps/http/rpc/Module.php'
    ]
]);

echo $application->handle()->getContent();