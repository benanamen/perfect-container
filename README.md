[![codecov](https://codecov.io/gh/benanamen/perfect-container/graph/badge.svg?token=9RC8mEw1Ty)](https://codecov.io/gh/benanamen/perfect-container)

# PerfectContainer

## Description

PerfectContainer is a lightweight, easy-to-use Dependency Injection Container designed for PHP applications. It facilitates the management of class dependencies, promoting a clean and decoupled codebase. PerfectContainer allows developers to bind interfaces to concrete implementations, making it easier to swap out dependencies without modifying the dependent classes.

## Features

- **Simple API**: Easy to use API for binding and resolving dependencies.
- **Singleton Binding**: Bind classes as singletons to reuse the same instance across the application.
- **Auto-Resolving**: Automatically resolve dependencies through type-hinted constructor injection.
- **PSR-11 Compliant**: Adheres to the PSR-11 Container Interface standard.

## Installation

Use Composer to install the PerfectContainer library.

```bash
composer require krubio/perfect-container
```

## Usage

Here's a basic usage example of PerfectContainer:

```php
require 'vendor/autoload.php';

use PerfectApp\Container\Container;

$container = new Container();

// Binding and resolving dependencies
$container->bind('SomeInterface', 'SomeImplementation');
$instance = $container->get('SomeInterface');
```

## Contributing

Contributions, issues, and feature requests are welcome!

## License

This project is [MIT](LICENSE) licensed.