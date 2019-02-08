<?php

namespace App\Services;

/**
 * Class Registry
 *
 * @package App\Services
 */
class Registry extends \ArrayObject
{
    /**
     * @var array
     */
    protected static $registry;

    /**
     * @param string $key
     * @param null   $data
     * @param array  $parameters
     *
     * @return mixed|null
     */
    public static function singleton(string $key, $data = null, array $parameters = [])
    {

        if (!static::has($key)) {
            if ($data instanceof \Closure) {
                static::put($key, $data($parameters));
            } else {
                static::put($key, $data);
            }
        }

        return static::get($key);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public static function has($key)
    {
        return self::getInstance()->offsetExists($key);
    }

    /**
     * @return \App\Services\Registry|array
     */
    public static function getInstance()
    {
        if (self::$registry == null) {
            self::$registry = new self();
        }

        return self::$registry;
    }

    /**
     * @param string $key
     * @param null   $data
     */
    public static function put(string $key, $data = null)
    {
        static::getInstance()->offsetSet($key, $data);
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public static function get(string $key)
    {
        if (self::has($key)) {
            return self::getInstance()->offsetGet($key);
        }

        return null;
    }

    /**
     * @param string $key
     */
    public function delete(string $key)
    {

        self::getInstance()->offsetUnset($key);
    }
}
