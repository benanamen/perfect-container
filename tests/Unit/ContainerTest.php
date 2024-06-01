<?php declare(strict_types=1);

namespace Unit;

use Codeception\Test\Unit;
use Fixtures\ClassWithDependencies;
use Fixtures\ExampleClass;
use PerfectApp\Container\Container;

class ContainerTest extends Unit
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    public function testBindAndResolveBinding(): void
    {
        $this->container->bind('example', ExampleClass::class);
        $instance = $this->container->get('example');
        $this->assertInstanceOf(ExampleClass::class, $instance);
    }

    public function testSetAndResolveBinding(): void
    {
        $this->container->set('example', ExampleClass::class);
        $instance = $this->container->get('example');
        $this->assertInstanceOf(ExampleClass::class, $instance);
    }

    public function testResolveClass(): void
    {
        $instance = $this->container->get(ExampleClass::class);
        $this->assertInstanceOf(ExampleClass::class, $instance);
    }

    public function testInstantiateClassWithoutConstructor(): void
    {
        $instance = $this->container->get(ExampleClass::class);
        $this->assertInstanceOf(ExampleClass::class, $instance);
    }

    public function testInstantiateClassWithConstructor(): void
    {
        $instance = $this->container->get(ClassWithDependencies::class);
        $this->assertInstanceOf(ClassWithDependencies::class, $instance);
    }
}
