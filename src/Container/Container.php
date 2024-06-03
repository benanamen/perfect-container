<?php declare(strict_types=1);

namespace PerfectApp\Container;

use Closure;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

class Container
{
    private array $instances = [];
    private array $bindings = [];

    /**
     * Binds an abstract to a concrete implementation.
     *
     * @deprecated Will be removed in Version 2. Use set() instead.
     */
    public function bind(string $abstract, mixed $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    /**
     * Sets an abstract to a concrete implementation (alias for bind).
     */
    public function set(string $abstract, mixed $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function get(string $className): mixed
    {
        if (isset($this->bindings[$className])) {
            $concrete = $this->bindings[$className];

            if ($concrete instanceof Closure) {
                return $concrete($this);
            }

            $className = $concrete;
        }

        if (!isset($this->instances[$className])) {
            try {
                $reflectionClass = new ReflectionClass($className);
            } catch (ReflectionException $e) {
                error_log("Failed to create ReflectionClass for $className: {$e->getMessage()}");
                http_response_code(500);
                throw new RuntimeException("Failed to create ReflectionClass for $className: {$e->getMessage()}");
            }

            $constructor = $reflectionClass->getConstructor();

            if ($constructor) {
                $params = $constructor->getParameters();
                $dependencies = [];

                foreach ($params as $param) {
                    $type = $param->getType();
                    if ($type && !$type->isBuiltin()) {
                        $dependency = $type->getName();
                        $dependencies[] = $this->get($dependency);
                    }
                }

                try {
                    $this->instances[$className] = $reflectionClass->newInstanceArgs($dependencies);
                } catch (ReflectionException $e) {
                    throw new RuntimeException("Failed to instantiate $className: {$e->getMessage()}");
                }
            } else {
                $this->instances[$className] = new $className();
            }
        }

        return $this->instances[$className];
    }
}
