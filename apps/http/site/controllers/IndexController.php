<?php

namespace Site\Controllers;

use Apps\Lib\AppMemcached;
use Phalcon\Mvc\Controller;

/**
 * Class IndexController
 * @package Site\Controllers
 */
class IndexController extends Controller
{
    public function indexAction()
    {

        $requestData['host'] = $this->request->getHttpHost();
        $requestData['uri'] = substr($this->request->get('_url'), 1);

        $appMemcache = new AppMemcached($this->getDI());

//        $cacheKey = $appMemcache->getCacheKey($requestData);
//        $cacheContent = $appMemcache->cache->get($cacheKey);

        if (!empty($cacheContent))
        {
            echo $cacheContent;

        } else {
            /**
             * Simple curl request to rpc server and view response
             */
            if ($curl = curl_init())
            {
                curl_setopt($curl, CURLOPT_URL, sprintf('http://rpc-server.dev/?host=%1$s&uri=%2$s',
                    $requestData['host'], $requestData['uri']));

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $out = curl_exec($curl);
                curl_close($curl);

                $result = json_decode($out, true);

                // write into memcache by key
                //$appMemcache->cache->save($cacheKey, $result);

                echo $out;
            }
        }


    }
}
