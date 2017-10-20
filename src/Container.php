<?php

namespace Stick\Container;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Container
 * @package Stick\Container
 */
class Container implements ContainerInterface
{

    /**
     * @var \stdClass
     */
    private $map;

    /**
     * @param string $yml
     * @return Container
     */
    public static function fromYAML(string $yml): Container
    {
        $configuration = Yaml::parse($yml);
        return new self($configuration);
    }

    /**
     * Container constructor.
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        $this->map = $configuration['map'];
        $this->initiateServices($configuration['services']);
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        if (isset($this->map[$id])) {
            if($this->map[$id] instanceof Service) {
                return $this->map[$id];
            } else {
                $implementation = $this->map[$id];
            }
        } else {
            throw new ObjectNotFoundException($id . " has no known implementation and is not known as a " . Service::class . " .");
        }
        $reflection = new \ReflectionClass($implementation);
        if($reflection->getConstructor() != null && count($reflection->getConstructor()->getParameters()) != 0) {
            // try to resolve them!
            $resolved = true;
            $resolvedParams = [];
            /**
             * @var $argument \ReflectionParameter
             */
            foreach ($reflection->getConstructor()->getParameters() as $argument) {
                $argumentClass = $argument->getClass();
                if($argumentClass == null) {
                    $resolved = false;
                    break;
                } else {
                    $class = $argumentClass->getName();
                    $classInstance = $this->get($class);
                    if($classInstance instanceof $class) {
                        $resolvedParams[] = $classInstance;
                    } else {
                        $resolved = false;
                        break;
                    }
                }
            }
            if($resolved) {
                $instance = new $implementation(...$resolvedParams);
            } else {
                $instance = new PreparedInstance($implementation);
            }
        } else {
            $instance = new $implementation();
        }
        return $instance;
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id)
    {
        return isset($this->map[$id]);
    }

    /**
     * @param string $service
     * @throws ServiceOfWrongTypeException
     */
    public function register(string $service)
    {
        $instance = new $service;
        if($instance instanceof Service) {
            $instance->boot();
            $this->map[$instance::$serviceId] = $instance;
        } else {
            throw new ServiceOfWrongTypeException($service . " is not a subclass of " . Service::class . '.');
        }
    }

    /**
     * @param string $interface
     * @param string $implementation
     */
    public function addImplementation(string $interface, string $implementation)
    {
        $this->map[$interface] = $implementation;
    }

    /**
     * @param array $services
     */
    private function initiateServices(array $services)
    {
        /**
         * @var $service string
         */
        foreach ($services as $service) {
            $this->register($service);
        }
    }

    /**
     * teardown everything
     */
    public function __destruct()
    {
        foreach ($this->map as $element) {
            if($element instanceof Service) {
                $element->teardown();
            }
        }
    }
}
