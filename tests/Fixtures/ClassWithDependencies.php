<?php declare(strict_types=1);

namespace Fixtures;



class ClassWithDependencies
{
    public function __construct(ExampleClass $example)
    {
    }
}