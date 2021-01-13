<?php

namespace app\core;

use app\core\errors\container\NotFoundContainerException;
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
    private array $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundContainerException($id);
        }

        return $this->values[$id];
    }

    public function has($id)
    {
        return array_key_exists($id, $this->values);
    }
}
