<?php

namespace app\core\errors\container;

use Exception;
use Psr\Container\ContainerExceptionInterface;

/**
 * Class InfiniteRecursionException
 *
 * @package app\core\errors\container
 */

class InfiniteRecursionException extends Exception implements ContainerExceptionInterface
{
    public function __construct(string $id, array $calls)
    {
        $calls = implode(', ', $calls);
        $message = "Infinite recursion for {$id} with stack calls {$calls}";
        parent::__construct($message);
    }
}
