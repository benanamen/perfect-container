<?php declare(strict_types=1);

namespace PerfectApp\Container;

use Closure;
use ReflectionClass;
use ReflectionException;

class Container
{
    private array $instances = [];
    private array $bindings = [];

    public function bind(string $abstract, mixed $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function get(string $className): object
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
                die('Fatal Error. See Error log for details.');
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
                    error_log("Failed to instantiate $className: {$e->getMessage()}");
                    die('Fatal Error. See Error log for details.');
                }
            } else {
                $this->instances[$className] = new $className();
            }
        }

        return $this->instances[$className];
    }
}
