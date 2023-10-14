<?php declare(strict_types=1);

namespace PerfectApp\Container;

use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

class Container
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    private array $bindings = [];

    public function bind(string $abstract, string $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function get(string $className): object
    {
        if (isset($this->bindings[$className])) {
            return $this->resolveBinding($className);
        }

        return $this->resolveClass($className);
    }

    private function resolveBinding(string $abstract): object
    {
        return $this->resolveClass($this->bindings[$abstract]);
    }

    private function resolveClass(string $className): object
    {
        try {
            $reflectionClass = new ReflectionClass($className);

            if (!$reflectionClass->isInstantiable()) {
                throw new ReflectionException("Class $className is not instantiable.");
            }

            $constructor = $reflectionClass->getConstructor();

            if (is_null($constructor)) {
                return new $className;
            }

            $constructorParameters = $constructor->getParameters();
            $dependencies = $this->resolveDependencies($constructorParameters);

            return $reflectionClass->newInstanceArgs($dependencies);

        } catch (ReflectionException $e) {
            $this->logger->error("Failed to create ReflectionClass for $className: {$e->getMessage()}");
            throw new RuntimeException('Fatal Error. See Error log for details.');
        }
    }

    private function resolveDependencies(array $parameters): array
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType()->getName();
            $dependencies[] = $this->get($dependency);
        }

        return $dependencies;
    }
}
