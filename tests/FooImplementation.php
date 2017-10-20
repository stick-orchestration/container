<?php

namespace Tests;

/**
 * Class FooImplementation
 * @package Tests
 */
class FooImplementation implements FooInterface
{

    /**
     * @return string
     */
    public function bar() : string
    {
        return "foobar";
    }
}
