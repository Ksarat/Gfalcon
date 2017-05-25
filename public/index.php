<?php

error_reporting(E_ALL);

use Phalcon\Loader;
use Phalcon\Mvc\Router;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application as BaseApplication;

/**
 * Class Application
 */
class Application extends BaseApplication
{
	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 */
	protected function registerServices()
	{
		$di = new FactoryDefault();
		$loader = new Loader();
		/**
		 * We're a registering a set of directories taken from the configuration file
		 */
		$loader
			->registerDirs([__DIR__ . '/../app/library/'])
			->register();

		// Registering a router
		$di->set('router', function ()
		{
			$router = new Router();

			$router->setDefaultModule("site");

			$router->add('/:params', [
				'module' => 'site',
				'controller' => 'index',
				'action' => 'index',
				'params' => 1,
			])->setName('site');

			return $router;
		});

		$this->setDI($di);
	}

	/**
	 *
	 */
	public function main()
	{
		$this->registerServices();

		// Register the installed modules
		$this->registerModules([
			'site' => [
				'className' => 'Site\Module',
				'path' => '../apps/http/site/Module.php'
			],
		]);

		echo $this->handle()->getContent();
	}
}

$application = new Application();
$application->main();
