<?php

namespace Site;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * Class Module
 * @package Site
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
				'Site\Controllers' => '../apps/http/site/controllers/',
				'Site\Models' => '../apps/http/site/models/',
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

			$dispatcher->setDefaultNamespace('Site\Controllers\\');

			return $dispatcher;
		});

		// Registering the view component
		$di->set('view', function ()
		{
			$view = new View();
			$view->setViewsDir('../apps/http/site/views/');

			return $view;
		});
	}
}
