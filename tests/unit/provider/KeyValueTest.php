<?php

namespace app\tests\unit\provider;

use app\core\LoaderInterface;
use app\core\provider\KeyValue;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class KeyValueTest
 * 
 * @package app\tests\unit\provider
 */

class KayValueTest extends TestCase
{
    public function testIsProvidable()
    {
        $provider = new KeyValue(['a' => 'value']);
        $this->assertTrue($provider->isProvidable('a'));
    }

    public function testProvide()
    {
        $container = $this->createMock(ContainerInterface::class);
        $provider = new KeyValue(['a' => 'value']);
        $this->assertEquals('value', $provider->provide('a', $container));
    }

    public function testProvideNotFoundException()
    {
        $this->expectException(NotFoundExceptionInterface::class);
        $this->expectExceptionMessage('Container name not found.');

        $container = $this->createMock(ContainerInterface::class);

        $provider = new KeyValue([]);
        $provider->provide('name', $container);
    }

    public function testProvideLoader()
    {
        $container = $this->createMock(ContainerInterface::class);
        $loader = $this->createMock(LoaderInterface::class);
        $loader->method('__invoke')
            ->willReturn(123);

        $provider = new KeyValue([
            'a' => $loader
        ]);
        $this->assertEquals(123, $provider->provide('a', $container));
    }
} 