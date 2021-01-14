<?php

namespace app\core;

use Psr\Container\ContainerInterface;

/**
 * Interface LoaderInterface
 *
 * @package app\core;
 */

interface LoaderInterface
{
    public function __invoke(ContainerInterface $container);
}
