<?php

namespace app\core;

use Psr\Container\ContainerInterface;

/**
 * Interface ProvoderInterface
 *
 * @package app\core
 */

interface ProviderInterface
{
    public function provide(string $id, ContainerInterface $container);

    public function isProvidable(string $id);
}
