[![codecov](https://codecov.io/gh/benanamen/perfect-container/graph/badge.svg?token=9RC8mEw1Ty)](https://codecov.io/gh/benanamen/perfect-container)
[![Build](https://github.com/benanamen/perfect-container/actions/workflows/build.yml/badge.svg)](https://github.com/benanamen/perfect-container/actions/workflows/build.yml)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/benanamen/perfect-container/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/benanamen/perfect-container/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/benanamen/perfect-container/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/benanamen/perfect-container/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/benanamen/perfect-container/badges/build.png?b=master)](https://scrutinizer-ci.com/g/benanamen/perfect-container/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/benanamen/perfect-container/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-container&metric=coverage)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-container)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-container&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-container)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-container&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-container)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-container&metric=sqale_index)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-container)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-container&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-container)

[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-container&metric=duplicated_lines_density)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-container)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-container&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-container)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-container&metric=bugs)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-container)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=benanamen_perfect-container&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=benanamen_perfect-container)






# PerfectContainer

## Description

PerfectContainer is a lightweight, easy-to-use Dependency Injection Container designed for PHP applications. It facilitates the management of class dependencies, promoting a clean and decoupled codebase. PerfectContainer allows developers to bind interfaces to concrete implementations, making it easier to swap out dependencies without modifying the dependent classes.

## Features

- **Simple API**: Easy to use API for binding and resolving dependencies.
- **Singleton Binding**: Bind classes as singletons to reuse the same instance across the application.
- **Auto-Resolving**: Automatically resolve dependencies through type-hinted constructor injection.
- **PSR-11 Compliant**: Adheres to the PSR-11 Container Interface standard.

## Upcoming Changes in Version 2.0.0

In Version 2.0.0, we are introducing a method renaming for improved consistency:

- **Method Renaming**: The `bind` method will be renamed to `set`. This change is aimed at providing clearer semantics and aligning with standard practices in dependency injection containers.


### Deprecation Notice

Starting from Version 1.1.0, the `bind` method is deprecated, and we encourage you to start using `set` to align with the upcoming changes in Version 2.0.0.

- **Deprecated**: The `bind` method is deprecated and will be removed in a future release (Version 2.0.0). Please update your usage to `set` to ensure compatibility with future versions.


We encourage you to update your usage accordingly to ensure compatibility with the latest version of PerfectContainer.

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
$container->set('SomeInterface', 'SomeImplementation');
$instance = $container->get('SomeInterface');
```

## Contributing

Contributions, issues, and feature requests are welcome!

## License

This project is [MIT](LICENSE) licensed.