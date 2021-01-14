<?php

namespace app\tests\unit;

use app\core\Container;
use app\core\ProviderInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * Class ContainerTest
 * 
 * @package app\tests\unit
 */

class ContainerTest extends TestCase
{
    public function testHello()
    {
        $this->assertTrue(true);
    }

    public function testGet()
    {
        $provider = new class implements ProviderInterface {
            public function provide(string $id, ContainerInterface $container) 
            {
                return 123;
            }

            public function isProvidable(string $id)
            {
                return true;
            }
        };
        // $provider = $this->createMock(ProviderInterface::class);
        // $provider->method('provide')
        //     ->with($this->equalTo('a', $this->createMock(ContainerInterface::class)))
        //     ->willReturn(123);
        // $provider->method('isProvidable')
        //     ->with($this->equalTo('a'))
        //     ->willReturn(true);
        /**
         * @var ProviderInterface $provider
         *  */    
        $container = new Container($provider);
        $this->assertEquals(123, $container->get('a'));
    }
} 