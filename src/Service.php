<?php

namespace Stick\Container;

/**
 * Abstract Class Service
 * @package Stick\Container
 */
abstract class Service
{

    /**
     * @var string
     */
    public static $serviceId;

    /**
     * @return void
     */
    abstract public function boot(): void;

    /**
     * @return void
     */
    abstract public function teardown(): void;
}
