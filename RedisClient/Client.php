<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 5/03/14
 * Time: 15:51
 */

namespace Solilokiam\HttpRedisCache\RedisClient;

use Redis;

class Client
{
    /**
     * @var Redis
     */
    protected $redis;

    /**
     * @var string
     */
    protected $host;
    
    /**
     * @var int
     */
    protected $port;
    
    /**
     * @var string
     */
    protected $password;
    
    /**
     * @var int
     */
    protected $database;
    
    /**
     * @var array
     */
    protected $options;


    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->redis = new Redis();
        $this->host = $params['host'];

        if (array_key_exists('port', $params)) {
            $this->port = $params['port'];
        }

        if (array_key_exists('password', $params)) {
            $this->password = $params['password'];
        }

        if (array_key_exists('database', $params)) {
            $this->database = $params['database'];
        }

        if (array_key_exists('options', $params)) {
            $this->options = $params['options'];
        }
    }

    /**
     * @return void
     */
    public function __destroy()
    {
        $this->redis->close();
    }

    /**
     * @return bool
     */
    public function createConnection()
    {
        $success = $this->redis->connect($this->host, $this->port);

        if ($this->password != null) {
            $success &= $this->redis->auth($this->password);
        }

        if ($this->database != null) {
            $success &= $this->redis->select($this->database);
        }

        if ($this->options != null) {
            foreach ($this->options as $key => $option) {
                $success &= $this->redis->setOption($key, $option);
            }
        }

        return $success;
    }

    /**
     * @param string $name
     * @param array  $arguments
     * 
     * @return boolean
     */
    public function __call($name, array $arguments)
    {
        switch (strtolower($name)) {
            case 'connect':
            case 'open':
            case 'pconnect':
            case 'popen':
            case 'setoption':
            case 'getoption':
            case 'auth':
            case 'select':
                return false;
        }

        $result = call_user_func_array(array($this->redis, $name), $arguments);

        return $result;
    }
}
