<?php

namespace app\tests\unit\loader;

use app\core\loader\Alias;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * Class AliasTest
 * 
 * @package app\tests\unit\loader
 */

class AliasTest extends TestCase
{
   public function testInvoke()
   {
       $container = $this->createMock(ContainerInterface::class);
       $container->method('get')
        ->with($this->equalTo('a'))
        ->willReturn(123);   

       $alias = new Alias('a');
       $this->assertEquals(123, $alias($container));
   } 
}