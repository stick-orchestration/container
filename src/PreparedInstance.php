<?php

namespace Stick\Container;

/**
 * Class PreparedInstance
 * @package Stick\Container
 */
class PreparedInstance
{

    /**
     * @var string
     */
    private $origin;

    /**
     * PreparedInstance constructor.
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->origin = $class;
    }

    /**
     * @param array ...$arguments
     * @return object
     */
    public function make(...$arguments)
    {
        return new $this->origin(...$arguments);
    }
}
