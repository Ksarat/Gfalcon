<?php

use Phalcon\Mvc\Router;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application as BaseApplication;

/**
 * Class Application
 */
class Application extends BaseApplication
{
	/**
	 *
	 */
	protected function registerServices()
	{
		if(!isset($di))
		{
			$di = new FactoryDefault();
		}

		/**
		 * Registering a router
		 */
		$di->set('router', function ()
		{
			$router = new Router();

			$router->setDefaultModule("site");

			$router->add('/:controller/:params', [
				'module' => 'site',
				'controller' => 'index',
				'action' => 'index',
				'params' => 2,
			]);

			return $router;
		});

		$this->setDI($di);
	}

	/**
	 *
	 */
	public function main()
	{
		/**
		 * Register the services
		 */
		$this->registerServices();

		/**
		 *  Register the installed modules
		 *   witch can also work with site part
		 */
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
