<?php

use Phalcon\Mvc\Router;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application as BaseApplication;

/**
 * Class Application
 */
class RpcApplication extends BaseApplication
{
	/**
	 * Register the services
	 */
	protected function registerServices()
	{
		if (!isset($di))
		{
			$di = new FactoryDefault();
		}

		// Registering a router
		$di->set('router', function ()
		{
			$router = new Router();

			$router->setDefaultModule("rpc");

			$router->add('/', [
				'module' => 'rpc',
				'controller' => 'index',
				'action' => 'index',
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
		$this->registerServices();

		/**
		 *  Register the installed modules witch can also work with rpc-server part
		 */
		$this->registerModules([
			'rpc' => [
				'className' => 'JsonRPC\Module',
				'path' => '../apps/http/rpc/Module.php'
			]
		]);

		echo $this->handle()->getContent();
	}
}

$application = new RpcApplication();
$application->main();
