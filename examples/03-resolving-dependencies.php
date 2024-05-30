<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PerfectApp\Container\Container;

class Dependency
{
    public function __construct()
    {
    }
}

class DependentClass
{
    public Dependency $dependency;

    public function __construct(Dependency $dependency)
    {
        $this->dependency = $dependency;
    }
}

$container = new Container();

// No need to bind Dependency class

// Resolve dependencies automatically
$instance = $container->get(DependentClass::class);

var_dump($instance);
