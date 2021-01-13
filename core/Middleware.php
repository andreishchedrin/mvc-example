<?php

namespace app\core;

/**
 * Class Middleware
 *
 * @package app\core
 */

abstract class Middleware
{
    abstract public function execute(): void;
}
