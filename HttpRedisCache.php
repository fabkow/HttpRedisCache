<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 5/03/14
 * Time: 15:46
 */

namespace Solilokiam\HttpRedisCache;


use Solilokiam\HttpRedisCache\Store\RedisHttpStore;
use Symfony\Bundle\FrameworkBundle\HttpCache\HttpCache;

class HttpRedisCache extends HttpCache
{
    
    /**
     * @return RedisHttpStore
     */
    public function createStore()
    {
        return new RedisHttpStore($this->getConnectionParams(), $this->getDigestKeyPrefix(), $this->getLockKey(
        ), $this->getMetadataKeyPrefix());
    }

    /**
     * @return array
     */
    public function getConnectionParams()
    {
        return array('host' => 'localhost');
    }

    /**
     * @return string
     */
    public function getDigestKeyPrefix()
    {
        return 'hrd';
    }

    /**
     * @return string
     */
    public function getLockKey()
    {
        return 'hrl';
    }

    /**
     * @return string
     */
    public function getMetadataKeyPrefix()
    {
        return 'hrm';
    }
}
