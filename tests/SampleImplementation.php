<?php

namespace Tests;

/**
 * Class SampleImplementation
 * @package Tests
 */
class SampleImplementation implements SampleInterface
{

    /**
     * @var SecondInterface
     */
    private $second;

    public function __construct(SecondInterface $second)
    {
        $this->second = $second;
    }

    /**
     * @param string $c
     * @return string
     */
    function abc(string $c) : string
    {
        return $c;
    }
}
