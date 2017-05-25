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

		if(!isset($di))
		{
			$di = new FactoryDefault();
		}


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

				$router->setDefaultModule("rpc");
				$router->add('/:params', [
					'module' => 'rpc',
					'controller' => 'index',
					'action' => 'index',
					'params' => 1,
				])->setName('rpc');

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
			'rpc' => [
				'className' => 'JsonRPC\Module',
				'path' => '../apps/http/rpc/Module.php'
			]
		]);

		echo $this->handle()->getContent();
	}
}

$application = new Application();
$application->main();
