<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Cache\Frontend\Data as DataFrontend;
use Phalcon\Cache\Backend\Memcache;
use Phalcon\Db\Adapter\Pdo\Mysql as MDatabase;
use Phalcon\Config\Adapter\Ini as ConfigIni;

if (!isset($di)) {
    $di = new FactoryDefault();
}

require(__DIR__.'/../config/' . APP_PATH . '/di.php');
require (__DIR__. '/../cbootstrap/crouter.php');


$di->setShared('db', function () use ($config)
{
    $dbConfig = (array) $config->database;
    $database =  new MDatabase($dbConfig);
    return $database;
});

/**
 * Set memcache in rpc
 * as long as possible
 */
$di->setShared('memcached', function ()
{
    $dataFrontend = new DataFrontend(["lifetime" => 0]);

    $memcacheConfig = new ConfigIni(__DIR__.'/../config/config.ini');

    return new Memcache($dataFrontend, [
            "servers" => [ (array) $memcacheConfig->memcache]
        ]
    );
});