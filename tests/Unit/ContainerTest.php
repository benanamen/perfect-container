<?php declare(strict_types=1);

namespace Unit;

use Codeception\Test\Unit;
use Fixtures\ClassWithDependencies;
use Fixtures\ExampleClass;
use Fixtures\NonInstantiableClass;
use PerfectApp\Container\Container;
use Psr\Log\LoggerInterface;
use RuntimeException;


class ContainerTest extends Unit
{
    private Container $container;
    private LoggerInterface $logger;

    protected function setUp(): void
    {
        // Mock the LoggerInterface
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->container = new Container($this->logger);
    }

    public function testBindAndResolveBinding(): void
    {
        $this->container->bind('example', ExampleClass::class);
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

    public function testReflectionExceptionHandling(): void
    {
        $this->logger->expects($this->once())
            ->method('error')
            ->with($this->stringContains('Failed to create ReflectionClass'));

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Fatal Error. See Error log for details.');

        $this->container->get('NonExistentClass');
    }

    public function testNonInstantiableClassThrowsException(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Fatal Error. See Error log for details.');

        $this->container->get(NonInstantiableClass::class);
    }
}
