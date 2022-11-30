# Laravel API Integration
[![Latest Version on Packagist](https://img.shields.io/packagist/v/rschoonheim/laravel-api-integration.svg?style=flat-square)](https://packagist.org/packages/rschoonheim/laravel-api-integration)
[![Total Downloads](https://img.shields.io/packagist/dt/rschoonheim/laravel-api-integration.svg?style=flat-square)](https://packagist.org/packages/rschoonheim/laravel-api-integration)

[![Master](https://github.com/rschoonheim/laravel-api-integration/actions/workflows/release.yml/badge.svg?branch=master)](https://github.com/rschoonheim/laravel-api-integration/actions/workflows/release.yml)

This package is a great starting point for integrating APIs into
your Laravel application. This package has an opinionated structure
that is designed to be generated and modified using Artisan commands.

## Installing the package
Install the package using the following Composer command:
```bash
$ composer require rschoonheim/laravel-api-integration
```

### Preparing your application
Before you can start using this package you need to run the
installation command. This command will create a `Integrations` folder
located in your `app` folder.

```bash
$  php artisan integration:install
```

## Using the package


### Creating a new HTTP integration
To create a new HTTP integration you must run the following Artisan
command:
```bash
$ php artisan integration:http:create
```
It will ask you for the name and the base URL of the API. It will generate the client in
the `app/Integrations/Http/{name}` folder. 



