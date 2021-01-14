<?php

namespace app\core\loader;

use app\core\LoaderInterface;
use Psr\Container\ContainerInterface;

/**
 * Class Alias
 *
 * @package app\core\loader
 */

class Alias implements LoaderInterface
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __invoke(ContainerInterface $container)
    {
        return $container->get($this->id);
    }
}
