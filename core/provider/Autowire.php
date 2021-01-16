<?php

namespace app\core\provider;

use app\core\errors\container\NotFoundContainerException;
use app\core\ProviderInterface;
use Psr\Container\ContainerInterface;
use ReflectionException;

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
            return AutowireReflection::provideDependencies($id, $container);
        } catch (ReflectionException $e) {
            throw new NotFoundContainerException($id);
        }
    }

    public function isProvidable(string $id)
    {
        return class_exists($id);
    }
}
