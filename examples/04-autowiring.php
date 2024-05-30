<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PerfectApp\Container\Container;

interface SomeInterface
{
    //
}

class Implementation implements SomeInterface
{
    //
}

class DependentClass
{
    public SomeInterface $dependency;

    public function __construct(SomeInterface $dependency)
    {
        $this->dependency = $dependency;
    }
}

$container = new Container();

// Bind the implementation to the interface
$container->bind(SomeInterface::class, Implementation::class);

// Resolve dependencies automatically
$instance = $container->get(DependentClass::class);

var_dump($instance);
