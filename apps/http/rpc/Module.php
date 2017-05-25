<?php

namespace JsonRPC;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Db\Adapter\Pdo\Mysql as Database;

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

		// Set a different connection in each module
		$di->set('db', function ()
		{
			return new Database(
				[
					"host" => "localhost",
					"username" => "root",
					"password" => "root",
					"dbname" => "rcp"
				]
			);
		});
	}
}
