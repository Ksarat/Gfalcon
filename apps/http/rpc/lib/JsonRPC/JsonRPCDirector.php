<?php

namespace JsonRPC\Lib;

use JsonRPC\Models\Blog;


/**
 * Class JsonRPCRouter
 * @package JsonRPC
 */
class JsonRPCDirector
{
	protected $data;

	/**
	 * JsonRPCDirector constructor.
	 *
	 * @param $data
	 */
	public function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * @return string
	 */
	public function receiveDataByRequest() : string
	{
	   $blog = new Blog();

		$contentData = $blog->getData($this->data);

		return $contentData;
	}

}