<?php

namespace app\core;

use app\core\errors\container\InfiniteRecursionException;
use app\core\errors\container\NotFoundContainerException;
use Psr\Container\ContainerInterface;

/**
 * Class Container
 *
 * @package app\core
 */

class Container implements ContainerInterface
{
    private $providers;
    private $values = [];
    private $calls = [];

    public function __construct(ProviderInterface ...$providers)
    {
        $this->providers = $providers;
    }

    public function get($id)
    {
        if (in_array($id, $this->calls)) {
            throw new InfiniteRecursionException($id, $this->calls);
        }
        $this->calls[] = $id;
        if (!array_key_exists($id, $this->values)) {
            $provider = $this->findProvider($id);
            if (null === $provider) {
                throw new NotFoundContainerException($id);
            }
            $this->values[$id] = $provider->provide($id, $this);
        }

        array_pop($this->calls);

        return $this->values[$id];
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
