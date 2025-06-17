# Wundii\afterbuy-sdk-Symfony-Bundle

[![PHP-Tests](https://github.com/wundii/afterbuy-sdk-symfony-bundle/actions/workflows/code_quality.yml/badge.svg)](https://github.com/wundii/afterbuy-sdk-symfony-bundle/actions/workflows/code_quality.yml)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%2010-brightgreen.svg?style=flat)](https://phpstan.org/)
![VERSION](https://img.shields.io/packagist/v/wundii/afterbuy-sdk-symfony-bundle)
[![PHP](https://img.shields.io/packagist/php-v/wundii/afterbuy-sdk-symfony-bundle)](https://www.php.net/)
[![Rector](https://img.shields.io/badge/Rector-8.2-blue.svg?style=flat)](https://getrector.com)
[![ECS](https://img.shields.io/badge/ECS-check-blue.svg?style=flat)](https://tomasvotruba.com/blog/zen-config-in-ecs)
[![PHPUnit](https://img.shields.io/badge/PHP--Unit-check-blue.svg?style=flat)](https://phpunit.org)
[![codecov](https://codecov.io/github/wundii/afterbuy-sdk-symfony-bundle/branch/main/graph/badge.svg?token=)](https://app.codecov.io/github/wundii/afterbuy-sdk-symfony-bundle)
[![Downloads](https://img.shields.io/packagist/dt/wundii/afterbuy-sdk-symfony-bundle.svg?style=flat)](https://packagist.org/packages/wundii/afterbuy-sdk-symfony-bundle)

A ***Symfony bundle*** providing seamless integration for the [wundii/afterbuy-sdk](https://github.com/wundii/afterbuy-sdk).


## Installation
Require the bundle and its dependencies with composer:

```bash
composer require wundii/afterbuy-sdk-symfony-bundle
```

Include the bundle in your `bundles.php`:

```php
return [
    // ...
    Wundii\AfterbuySdk\SymfonyBundle\AfterbuyBundle::class => ['all' => true],
];
```

Create a Symfony configuration file `config/packages/afterbuy_sdk.yaml` with the command:

```bash
bin/console afterbuy-sdk:default-config
```

## Configuration File
The following setting options are available

```yaml
afterbuy_sdk:
    data_config:
        approach: 'CONSTRUCTOR|PROPERTY|SETTER' # ApproachEnum::SETTER
        accessible: 'PRIVATE|PUBLIC' # AccessibleEnum::PUBLIC
        class_map: 
          InterfaceOrClassName: 'ClassName', # Class mapping for interfaces or other classes
          ...: ...
```