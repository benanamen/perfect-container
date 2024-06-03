<?php declare(strict_types=1);

namespace Fixtures;

use ReflectionException;

class ClassWithConstructorException
{
    public function __construct()
    {
        throw new ReflectionException('Mock exception during instantiation');
    }
}
