<?php

namespace JsonRPC\Controllers;

use Phalcon\Mvc\Controller;
use JsonRPC\Lib\JsonRPCResponse;
use JsonRPC\Lib\JsonRPCDirector;
use JsonRPC\Lib\Exceptions\BadRequestException;
use JsonRPC\Lib\Exceptions\NotFoundException;
use JsonRPC\Lib\Exceptions\InvalidArgumentException;

class IndexController extends Controller
{
    public function indexAction()
    {
	    $response = new JsonRPCResponse();

	    try
	    {
		    $requestContent = $this->getContentByRequest();
		    $response->setStatusCode(200);
	    }
	    catch ( BadRequestException $e)
	    {
		    $response->setStatusCode(400, 'Bad request');

	    }
	    catch ( NotFoundException $e)
	    {
		    $response->setStatusCode(404, 'Not found');
	    }
	    catch ( InvalidArgumentException $e)
	    {
		    $response->setStatusCode(403, 'Invalid arguments');
	    }
	    catch ( Exception $e)
	    {
		    $response->setStatusCode($e->getCode(), $e->getMessage());
	    }

	    $response->setJsonContent($requestContent);

	    return $response;
    }

	/**
	 *
	 */
	private function getContentByRequest(): string
	{
		if (!$this->request->isGet())
		{
			throw new BadRequestException();
		}

		$requestData['uri'] = substr($this->request->get('_url'), 1);
		$requestData['host'] = $this->request->getHttpHost();

		if(!$this->isDataValid($requestData))
		{
			throw new InvalidArgumentException();
		}

		$jsonDirector = new JsonRPCDirector($requestData);



		$contentData = $jsonDirector->receiveDataByRequest();

		if(empty($contentData))
		{
			throw new NotFoundException();
		}

		return $contentData;
	}

	/**
	 * @param $data
	 *
	 * @return bool
	 */
	public function isDataValid($data) : bool
	{
		if (empty($data['uri']) || empty($data['host']))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

}
