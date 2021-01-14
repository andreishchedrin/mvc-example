<?php

namespace app\core\provider;

use app\core\errors\container\NotFoundContainerException;
use app\core\ProviderInterface;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Class Autowire
 *
 * @package app\core\provider
 */

class Autowire implements ProviderInterface
{
    public function provide(string $id, ContainerInterface $container)
    {
        try {
            $class = new ReflectionClass($id);
            $dependencies = $this->getDependencies($class);
            $args = [];
            foreach ($dependencies as $dependency) {
                $args[] = $container->get($dependency);
            }
            return $class->newInstanceArgs($args);
        } catch (ReflectionException $e) {
            throw new NotFoundContainerException($id);
        }
    }

    private function getDependencies(ReflectionClass $class): array
    {
        $constructor = $class->getConstructor();
        if (null === $constructor) {
            return [];
        }
        return $this->readConstructor($constructor);
    }

    private function readConstructor(ReflectionMethod $constructor): array
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

    public function isProvidable(string $id)
    {
        return class_exists($id);
    }
}
