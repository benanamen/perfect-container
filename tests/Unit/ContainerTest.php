<?php declare(strict_types=1);

namespace Unit;

use Codeception\Test\Unit;
use Fixtures\ClassWithConstructorException;
use Fixtures\ClassWithDependencies;
use Fixtures\ExampleClass;
use PerfectApp\Container\Container;
use RuntimeException;

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

    public function testResolveBindingWithClosure(): void
    {
        $exampleInstance = new ExampleClass();
        $closure = function () use ($exampleInstance) {
            return $exampleInstance;
        };

        $this->container->bind('example', $closure);

        $resolvedInstance = $this->container->get('example');
        $this->assertSame($exampleInstance, $resolvedInstance);
    }

    public function testHandleReflectionClassException(): void
    {
        // Create a temporary error log file in the project directory
        $errorLogFile = __DIR__ . '/error.log';

        // Capture the original error log path
        $originalErrorLogPath = ini_get('error_log');

        // Set the error log path to the temporary file
        ini_set('error_log', $errorLogFile);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Failed to create ReflectionClass for NonExistingClassName');

        try {
            $this->container->get('NonExistingClassName');
        } finally {
            // Restore the original error log path
            ini_set('error_log', $originalErrorLogPath);

            // Assert that the error log file contains the expected message
            $errorLogContents = file_get_contents($errorLogFile);
            $this->assertStringContainsString('Failed to create ReflectionClass for NonExistingClassName', $errorLogContents);

            // Clean up the temporary error log file
            unlink($errorLogFile);
        }
    }

    public function testHandleReflectionExceptionDuringInstantiation(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Failed to instantiate Fixtures\ClassWithConstructorException: Mock exception during instantiation');

        // Attempt to get the instance, which should trigger the ReflectionException and our catch block
        $this->container->get(ClassWithConstructorException::class);
    }
}
