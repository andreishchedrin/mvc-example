<?php

namespace app\core\provider;

use app\core\errors\container\NotFoundContainerException;
use app\core\LoaderInterface;
use app\core\ProviderInterface;
use Psr\Container\ContainerInterface;

/**
 * Class KeyValue
 *
 * @package app\core\provider
 */

class KeyValue implements ProviderInterface
{
    private array $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function provide(string $id, ContainerInterface $container)
    {
        if (!$this->isProvidable($id)) {
            throw new NotFoundContainerException($id);
        }
        $result = $this->values[$id];

        if ($result instanceof LoaderInterface) {
            $result = $result($container);
        }
        return $result;
    }

    public function isProvidable(string $id)
    {
        return array_key_exists($id, $this->values);
    }
}
