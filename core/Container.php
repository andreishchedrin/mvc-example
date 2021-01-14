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
    private $providers;

    public function __construct(ProviderInterface ...$providers)
    {
        $this->providers = $providers;
    }

    public function get($id)
    {
        $provider = $this->findProvider($id);
        if (null === $provider) {
            throw new NotFoundContainerException($id);
        }

        return $provider->provide($id, $this);
    }

    public function has($id)
    {
        return !is_null($this->findProvider($id));
    }

    private function findProvider(string $id): ?ProviderInterface
    {
        foreach ($this->providers as $provider) {
            if ($provider->isProvidable($id)) {
                return $provider;
            }
        }

        return null;
    }
}
