<?php

namespace JsonRPC;

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Exception;

/**
 * Class JsonRPCRouter
 * @package JsonRPC
 */
class JsonRPCRouter extends Router
{
	protected $_data;

	public function __construct($data)
	{
		$this->_data = $data;
	}

	public function handle($data=null)
	{

		if (!$data) {
			$data = $this->_data;
		}

		$data = json_decode($data, true);

		if (!isset($data['jsonrpc'])) {
			throw new Exception("The request is not Json-RPC");
		}

		$method = explode('.', $data['method']);

		$this->_controller = $method[0];
		$this->_action = $method[1];
		$this->_params = $data['params'];
	}

}