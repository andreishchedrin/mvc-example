<?php

namespace app\core;

use Closure;
use Exception;
use Psr\Container\ContainerInterface;
use ReflectionClass;

/**
 * Class Container
 *
 * @package app\core
 */

class Container implements ContainerInterface
{

    public function get($id)
    {
        //
    }

    public function has($id): bool
    {
        return true;
    }
}
