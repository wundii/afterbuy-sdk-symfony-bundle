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

## Afterbuy API Documentation
- [Shop API Documentation](https://xmldoku.afterbuy.de/shopdoku/)
- [XML API Documentation](https://xmldoku.afterbuy.de/dokued/)

### Supported Requests with Examples
- [x] [CreateShopOrder](https://github.com/wundii/afterbuy-sdk/tree/main/examples/CreateShopOrder.md)
- [x] [GetAfterbuyTime](https://github.com/wundii/afterbuy-sdk/tree/main/examples/GetAfterbuyTime.md)
- [x] [GetListerHistory](https://github.com/wundii/afterbuy-sdk/tree/main/examples/GetListerHistory.md)
- [x] [GetMailTemplates](https://github.com/wundii/afterbuy-sdk/tree/main/examples/GetMailTemplates.md)
- [x] [GetPaymentServices](https://github.com/wundii/afterbuy-sdk/tree/main/examples/GetPaymentServices.md)
- [x] [GetProductDiscounts](https://github.com/wundii/afterbuy-sdk/tree/main/examples/GetProductDiscounts.md)
- [x] [GetShippingCost](https://github.com/wundii/afterbuy-sdk/tree/main/examples/GetShippingCost.md)
- [x] [GetShippingServices](https://github.com/wundii/afterbuy-sdk/tree/main/examples/GetShippingServices.md)
- [x] [GetShopCatalogs](https://github.com/wundii/afterbuy-sdk/tree/main/examples/GetShopCatalogs.md)
- [x] [GetShopProducts](https://github.com/wundii/afterbuy-sdk/tree/main/examples/GetShopProducts.md)
- [x] [GetSoldItems](https://github.com/wundii/afterbuy-sdk/tree/main/examples/GetSoldItems.md)
- [x] [GetStockInfo](https://github.com/wundii/afterbuy-sdk/tree/main/examples/GetStockInfo.md)
- [x] [GetTranslatedMailTemplate](https://github.com/wundii/afterbuy-sdk/tree/main/examples/GetTranslatedMailTemplate.md)
- [x] [UpdateCatalogs](https://github.com/wundii/afterbuy-sdk/tree/main/examples/UpdateCatalogs.md)
- [x] [UpdateShopProducts](https://github.com/wundii/afterbuy-sdk/tree/main/examples/UpdateShopProducts.md)
- [x] [UpdateSoldItems](https://github.com/wundii/afterbuy-sdk/tree/main/examples/UpdateSoldItems.md)

## Installation
Require the bundle and its dependencies with composer:

```bash
composer require wundii/afterbuy-sdk-symfony-bundle
```

Include the bundle in your `bundles.php`:

```php
return [
    // ...
    Wundii\AfterbuySdk\SymfonyBundle\AfterbuySdkBundle::class => ['all' => true],
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
  afterbuy_global:
    accountToken: <your_account_token> / "%env(...)%"
    partnerToken: <your_partner_token> / "%env(...)%"
    endpointEnum: sandbox
    errorLanguageEnum: DE
  logger_interface: <your_logger_interface_class_string>
  validatorBuilder: <your_validatorBuilder_class_string>

when@test:
  afterbuy_sdk:
    afterbuy_global:
      endpointEnum: sandbox

when@prod:
  afterbuy_sdk:
    afterbuy_global:
      endpointEnum: prod
```

### After modifying the configuration, it is recommended to clear the cache

```bash
bin/console cache:clear
```