<?php

namespace Tests;

use Stick\Container\Service;

/**
 * Class SampleService
 * @package Tests
 */
class SampleService extends Service
{

    /**
     * @var string
     */
    public static $serviceId = "sample";

    /**
     * @return void
     */
    public function boot() : void
    {
        // TODO: Implement boot() method.
    }

    /**
     * @return void
     */
    public function teardown() : void
    {
        // TODO: Implement teardown() method.
    }
}
