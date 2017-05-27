<?php

namespace JsonRPC\Controllers;

use Apps\Lib\AppMemcached;
use Phalcon\Mvc\Controller;
use JsonRPC\Lib\JsonRPCResponse;
use JsonRPC\Lib\JsonRPCDirector;
use JsonRPC\Lib\Exceptions\BadRequestException;
use JsonRPC\Lib\Exceptions\NotFoundException;
use JsonRPC\Lib\Exceptions\InvalidArgumentException;

/**
 * Class IndexController
 * @package JsonRPC\Controllers
 */
class IndexController extends Controller
{

	/**
	 * @return JsonRPCResponse
	 */
	public function indexAction()
	{

		$response = new JsonRPCResponse();
		$requestContent = [];

		try
		{
			$requestData = $this->getRequestData();

			$rpcCache = new AppMemcached($this->getDI());

			if($requestData['clear'] == 'true')
			{
				$rpcCache->clearCache();
			}

			if (!$this->isDataValid($requestData))
			{
				throw new InvalidArgumentException();
			}

			$requestContent = $this->getContentByRequest($requestData);

			$response->setStatusCode(200);
		}
		catch (BadRequestException $e)
		{
			$response->setStatusCode(400, 'Bad request');
		}
		catch (NotFoundException $e)
		{
			$response->setStatusCode(404, 'Not found');
		}
		catch (InvalidArgumentException $e)
		{
			$response->setStatusCode(403, 'Invalid arguments');
		}
		catch (\Exception $e)
		{
			$response->setStatusCode($e->getCode(), $e->getMessage());
		}

		$response->setJsonContent($requestContent);

		return $response;
	}

	/**
	 * @return array
	 * @throws BadRequestException
	 * @throws InvalidArgumentException
	 */
	private function getRequestData(): array
	{
		if (!$this->request->isGet())
		{
			throw new BadRequestException();
		}

		$jsonData = $this->request->getJsonRawBody(true);

		if ($jsonData)
		{
			$requestData['uri'] = $jsonData['uri'];
			$requestData['host'] = $jsonData['host'];
			$requestData['clear'] = $jsonData['clear'];
		}
		else
		{
			$requestData['uri'] = $this->request->get('uri');
			$requestData['host'] = $this->request->get('host');
			$requestData['clear'] = $this->request->get('clear');
		}

		return $requestData;
	}

	/**
	 * @param $requestData
	 *
	 * @return string
	 * @throws NotFoundException
	 */
	private function getContentByRequest($requestData): string
	{
		$jsonDirector = new JsonRPCDirector($requestData);

		$contentData = $jsonDirector->receiveDataByRequest();

		if (empty($contentData))
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
	public function isDataValid($data): bool
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
