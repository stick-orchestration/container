<?php
/**
 * Created by PhpStorm.
 * User: Alexander Jank
 * Date: 20.10.2017
 * Time: 16:52
 */

namespace Tests;

use Stick\Container\Container;
use PHPUnit\Framework\TestCase;
use Stick\Container\PreparedInstance;

class ContainerTest extends TestCase
{
    public function testImplementationMapper()
    {
        $container = Container::fromYAML(file_get_contents(__DIR__.'/sampleConf.yml'));

        $this->assertInstanceOf(FooImplementation::class, $container->get(FooInterface::class));

        $resultSample = $container->get(SampleInterface::class);
        $this->assertInstanceOf(PreparedInstance::class, $resultSample);

        $resultSecond = $container->get(SecondInterface::class);
        $this->assertInstanceOf(PreparedInstance::class, $resultSecond);
        $second = $resultSecond->make('cars');
        $this->assertInstanceOf(SecondImplementation::class, $second);

        $sample = $resultSample->make($second);
        $this->assertInstanceOf(SampleImplementation::class, $sample);
    }
}
