<?php

namespace app\core\provider;

use app\core\errors\container\NotFoundContainerException;
use app\core\ProviderInterface;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\SimpleCache\CacheInterface;
use ReflectionClass;
use ReflectionException;

/**
 * Class AutowireCache
 * 
 * @package app\core\provider
 */

class AutowireCache implements ProviderInterface
{
    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function provide(string $id, ContainerInterface $container)
    {
        $args = [];
        
        if (!$this->cache->has($id)) {
            try { 
                $class = new ReflectionClass($id);
                $this->cache->set($id, AutowireReflection::getDependencies($class));               
            } catch (ReflectionException | InvalidArgumentException $e) {
                throw new NotFoundContainerException($id);
            }
        }

        foreach ($this->cache->get($id) as $dependency) {
            $args[] = $container->get($dependency);
        }

        return new $id(...$args);
    }

    public function isProvidable(string $id)
    {
        return class_exists($id);
    }
}
