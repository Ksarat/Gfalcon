<?php

namespace Site\Controllers;

use Phalcon\Mvc\Controller;

/**
 * Class IndexController
 * @package Site\Controllers
 */
class IndexController extends Controller
{
	public function indexAction()
	{

		/**
		 * Simple curl request to rpc server and view response
		 */
		if ($curl = curl_init())
		{

			curl_setopt($curl, CURLOPT_URL, sprintf('http://rpc-server.dev/?host=%1$s&uri=%2$s',
				$this->request->getHttpHost(), substr($this->request->get('_url'), 1)));

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			$out = curl_exec($curl);
			$result = json_decode($out, true);

			curl_close($curl);

			echo $out;
		}
	}
}
