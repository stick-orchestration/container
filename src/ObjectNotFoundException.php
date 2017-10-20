<?php

namespace Stick\Container;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class ImplementationNotFoundException
 * @package Stick\Container
 */
class ObjectNotFoundException extends \Exception implements NotFoundExceptionInterface {}
