<?php

namespace app\core\provider;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionMethod;

/**
 * Class AutowireReflection
 *
 * @package app\core\provider
 */

class AutowireReflection
{
    public static function provideDependencies(string $class, ContainerInterface $container)
    {
        $class = new ReflectionClass($class);
        $dependencies = self::getDependencies($class);
        $args = [];
        foreach ($dependencies as $dependency) {
            $args[] = $container->get($dependency);
        }
        return $class->newInstanceArgs($args);
    }

    public static function getDependencies(ReflectionClass $class): array
    {
        $constructor = $class->getConstructor();
        if (null === $constructor) {
            return [];
        }
        return self::readConstructor($constructor);
    }

    public static function readConstructor(ReflectionMethod $constructor): array
    {
        $result = [];
        foreach ($constructor->getParameters() as $parameter) {
            $class = $parameter->getClass();
            if (null !== $class) {
                $result[] = $class->name;
            } else {
                $result[] = $parameter->name;
            }
        }

        return $result;
    }
}
