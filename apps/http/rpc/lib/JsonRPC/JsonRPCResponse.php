<?php

namespace JsonRPC\Lib;

use Phalcon\Http\Response as Response;

/**
 * Class Response
 * @package JsonRPC
 */
class JsonRPCResponse extends Response
{

	/**
	 *  Content result
	 * @var
	 */
	public $result;

	/**
	 * @param mixed $requestContent
	 *
	 * @return Response|string
	 */
	public function setJsonContent($requestContent)
	{
		$response = [];

		$statusResponse =  $this->getStatusCode();

		$response['code'] = $statusResponse['code'];
		$response['message'] = $statusResponse['message'];;
		$response['result'] = $requestContent;

		$this->result = parent::setJsonContent($response);

		return $this->result;
	}

	/**
	 * @return array
	 */
	public function getStatusCode() : array
	{
		$statusResponse['code'] = substr(parent::getStatusCode(), 0, 3);
		$statusResponse['message'] = substr(parent::getStatusCode(), 3);

		return $statusResponse;
	}

}