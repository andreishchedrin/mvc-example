<?php

namespace app\tests\unit\loader;

use app\core\loader\Alias;
use app\core\loader\Service;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * Class ServiceTest
 * 
 * @package app\tests\unit\loader
 */

class ServiceTest extends TestCase
{
    public function testInvoke()
    {
        $container = $this->createMock(ContainerInterface::class);

        $service = new Service(function () {
            return 123;
        });
        $this->assertEquals(123, $service($container));
    }

    public function testInkoveComplex()
    {
        $container = new class implements ContainerInterface {
            public function get($id)
            {
                $a = [
                    'type' => 'mysql',
                    'name' => 'test'
                ];
                return $a[$id];
            }

            public function has($id)
            {
                
            }
        };

        $service = new Service(function (ContainerInterface $container) {
            return "{$container->get('type')}://dbName={$container->get('name')}";
        });

        $this->assertEquals('mysql://dbName=test', $service($container));
    }
}
