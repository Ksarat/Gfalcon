<?php

use Phalcon\Config\Adapter\Ini as ConfigIni;

/**
 * get different config
 */
$config = new ConfigIni(__DIR__.'/../config/' . APP_PATH . '/config.ini');

require (__DIR__. '/../cbootstrap/cdi.php');