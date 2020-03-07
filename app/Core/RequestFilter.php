<?php


namespace Jman\Core;

class RequestFilter
{

    private $map;

    public function __construct($sourceMap)
    {
        $this->map = $sourceMap;
    }


    /**
     * Checks if parameter name exists in the map.
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->map[$name]);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        if (!$this->has($name))
            return null;
        return $this->map[$name];
    }

    /**
     * @param $name
     * @param bool $filter
     * @return string
     */
    public function getString($name, $filter = true): ?string
    {
        if (!$this->has($name))
            return null;

        if ($filter) {
            return addslashes($this->map[$name]);
        } else {
            return $this->get($name);
        }
    }

    /**
     * @param $name
     * @return int|null
     */
    public function getInt($name): ?int
    {
        if (!$this->has($name))
            return null;

        return intval($this->map[$name]);
    }

    /**
     * @param $name
     * @return float
     */
    public function getFloat($name): ?float
    {
        if (!$this->has($name))
            return null;
        return floatval($this->map[$name]);
    }

}