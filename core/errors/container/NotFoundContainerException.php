<?php

namespace app\core\errors\container;

use InvalidArgumentException;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class NotFoundContainerException
 *
 * @package app\core\errors
 */

class NotFoundContainerException extends InvalidArgumentException implements NotFoundExceptionInterface
{

}
