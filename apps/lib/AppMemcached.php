<?php

namespace Apps\Lib;

use Phalcon\Cache\Backend\Memcache;
use Phalcon\DiInterface;

/**
 * Class AppMemcached
 * @package Apps\Lib
 */
class AppMemcached
{
	/**
	 * @var Memcache
	 */
	public $cache;

	/**
	 * RpcCache constructor.
	 *
	 * @param DiInterface $di
	 */
	public function __construct(DiInterface $di)
	{
		$this->cache = $di->getMemcached();
	}

	/**
	 * @param $requestContent
	 *
	 * @return string
	 */
	public function getCacheKey($requestContent): string
	{
		$key = sprintf('%1$s.%2$s',$requestContent['host'],$requestContent['uri']);

		return $key;
	}

	/**
	 * Clear cache
	 */
	public function clearCache()
	{
		echo 'deleted';exit;

		// delete all from cache

//		$keys = $this->cache->queryKeys();
//		foreach ($keys as $key)
//		{
//			$rpcCache->cache->delete($key);
//		}
	}



}
