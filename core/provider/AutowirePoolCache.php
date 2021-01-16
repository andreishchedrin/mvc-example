<?php

namespace app\core\provider;

use app\core\errors\container\NotFoundContainerException;
use app\core\ProviderInterface;
use InvalidArgumentException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;

/**
 * Class AutowirePoolCache
 * 
 * @package app\core\provider
 */

class AutowirePoolCache implements ProviderInterface 
{
    private $pool;

    public function __construct(CacheItemPoolInterface $pool)
    {
        $this->pool = $pool;
    }

    public function provide(string $id, ContainerInterface $container)
    {
        $args = [];

        try {
            $item = $this->pool->getItem($id);
            if (!$item->isHit()) {
                $class = new ReflectionClass($id);
                $dependencies = AutowireReflection::getDependencies($class);
                $item->set($dependencies);
                $this->pool->save($item);
                foreach ($item->get() as $dependency) {
                    $args[] = $container->get($dependency);
                }
        
                return new $id(...$args);
            }
        } catch (ReflectionException | InvalidArgumentException $e) {
            throw new NotFoundContainerException($id);
        }
    }

    public function isProvidable(string $id)
    {
        return class_exists($id);
    }
}