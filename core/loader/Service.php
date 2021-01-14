<?php

namespace app\core\loader;

use app\core\LoaderInterface;
use Closure;
use Psr\Container\ContainerInterface;

/**
 * Class Service
 *
 * @package app\core\loader
 */

class Service implements LoaderInterface
{
    private Closure $closure;

    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    public function __invoke(ContainerInterface $container)
    {
        return ($this->closure)($container);
    }
}
