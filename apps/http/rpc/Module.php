<?php

namespace JsonRPC;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Db\Adapter\Pdo\Mysql as Database;
use Phalcon\Cache\Frontend\Data as DataFrontend;
use Phalcon\Cache\Backend\Memcache;

/**
 * Class Module
 * @package JsonRPC
 */
class Module implements ModuleDefinitionInterface
{
	/**
	 * Registers the module auto-loader
	 *
	 * @param DiInterface $di
	 */
	public function registerAutoloaders(DiInterface $di = null)
	{
		$loader = new Loader();

		$loader->registerNamespaces(
			[
				'JsonRPC\Controllers' => '../apps/http/rpc/controllers/',
				'JsonRPC\Models' => '../apps/http/rpc/models/',
				'JsonRPC\Lib\Exceptions' => '../apps/http/rpc/lib/JsonRPC/Exeptions/',
				'JsonRPC\Lib' => '../apps/http/rpc/lib/JsonRPC/',

			]
		);

		$loader->register();
	}

	/**
	 * Registers services related to the module
	 *
	 * @param DiInterface $di
	 */
	public function registerServices(DiInterface $di)
	{
		// Registering a dispatcher
		$di->set('dispatcher', function ()
		{
			$dispatcher = new Dispatcher();
			$dispatcher->setDefaultNamespace('JsonRPC\Controllers\\');

			return $dispatcher;
		});

		// Registering the view component
		$di->set('view', function ()
		{
			$view = new View();
			$view->setViewsDir('../apps/http/rpc/views/');

			return $view;
		});

		/**
		 * Set memcache in rpc
		 * as long as possible
		 */
		$di->setShared('memcached', function ()
		{
			$dataFrontend = new DataFrontend(["lifetime" => 0]);
			return new Memcache($dataFrontend, [
					"servers" => [
						[
							"host" => "127.0.0.1",
							"port" => "11211",
							"weight" => "1",
						]
					]
				]
			);
		});

		// Set a different connection in each module
		$di->set('db', function ()
		{
			return new Database(
				[
					"host" => "rpchost",
					"username" => "rpcroot",
					"password" => "rpcroot",
					"dbname" => "rpcrcp"
				]
			);
		});
	}
}
