<?php

use Phalcon\Mvc\Application;

define('APP_PATH', 'site');

require (__DIR__. '/../cbootstrap/cconfig.php');



$application = new Application($di);

$application->registerModules([
    'site' => [
        'className' => 'Site\Module',
        'path' => '../apps/http/site/Module.php'
    ],
]);

echo $application->handle()->getContent();
