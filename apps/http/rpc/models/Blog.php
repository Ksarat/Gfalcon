<?php

namespace JsonRPC\Models;

use Phalcon\Mvc\Model;

/**
 * Class Blog
 * @package JsonRPC\Models
 */
class Blog extends Model
{
	/**
	 * @param array $data
	 *
	 * @return string
	 */
	public function getData(array $data): string
	{
		/**
		 * Connect to BD using Data - uri adn host and get required data
		 *
		 * $result = self::find($data);
		 */

		//to see error Not Found
		if ($data['uri'] == 'empty')
		{
			return '';
		}

		return sprintf('<html><p>%1$s</p><p>%2$s</p></html>', $data['host'], $data['uri']);
	}


}
