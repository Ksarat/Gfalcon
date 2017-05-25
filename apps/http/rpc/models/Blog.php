<?php

namespace JsonRPC\Models;

use Phalcon\Mvc\Model;

class Blog extends Model
{
	/**
	 * @param array $data
	 *
	 * @return string
	 */
	public function getData(array $data): string
	{
		//connect to BD and get required data


		//to see error Not Found
		if ($data['uri'] == 'empty')
		{
			return '';
		}

		return sprintf('<html><p>%1$s</p><p>%2$s</p></html>', $data['host'], $data['uri']);
	}


}
