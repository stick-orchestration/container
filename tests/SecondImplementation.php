<?php

namespace Tests;

/**
 * Class SecondImplementation
 * @package Tests
 */
class SecondImplementation implements SecondInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * SecondImplementation constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function methodTwo(): string
    {
        return "two " . $this->name;
    }
}
