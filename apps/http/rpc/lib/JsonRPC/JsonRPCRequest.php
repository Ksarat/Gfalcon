<?php
namespace JsonRPC\Lib;

use Phalcon\Http\Request;

class JsonRPCRequest extends Request
{
	/**
	 * Rpc requests
	 * @var \Request[]
	 */
	protected $rpcRequests = [];

	/**
	 * Constructor
	 * @return void
	 */
	public function __construct()
	{
		// creates rpc requests collection from raw body
		// and adds them to $this->rpcRequests
	}
}