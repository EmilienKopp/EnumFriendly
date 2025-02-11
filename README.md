# EnumFriendly

![Tests](https://img.shields.io/github/actions/workflow/status/emilienkopp/EnumFriendly/tests.yml?label=tests)
<!-- [![Coverage Status](https://img.shields.io/coveralls/github/emilienkopp/EnumFriendly/main.svg?style=flat-square)](https://coveralls.io/github/emilienkopp/EnumFriendly?branch=main) -->
![PHP Version](https://img.shields.io/badge/php-^8.1-blue.svg?style=flat-square)
![Laravel Version](https://img.shields.io/badge/laravel-^11.0-orange.svg?style=flat-square)

## Introduction

EnumFriendly is a PHP package that provides a friendly interface for working with enums in Laravel applications.

## Installation

You can install the package via composer:

```bash
composer require yourusername/enum-friendly
```

## Usage

### Creating a Friendly Enum

You can use the `MakeFriendlyEnum` command to create a new friendly enum.

```bash
php artisan split:enum {name} {--type= : string or int, the backed type} {--u|upper : Convert the case name to uppercase} {values*}
```

Example:

```bash
php artisan split:enum Status --type=string active:ACTIVE inactive:INACTIVE
```

This will create an enum `Status` with the following cases and the `ExtendedEnum` trait:

```php
use Splitstack\EnumFriendly\Traits\ExtendedEnum;

enum Status: string
{
  use ExtendedEnum;

  case ACTIVE = 'active';
  case INACTIVE = 'inactive';
}
```

### Using the ExtendedEnum Trait

The `ExtendedEnum` trait provides additional methods for your enums,
(string-backed, int-backed, or plain).

```php
use Splitstack\EnumFriendly\Traits\ExtendedEnum;

enum MyEnum: string
{
  use ExtendedEnum;

  case ADMIN = 'admin';
  case USER = 'user';
}
```

#### Methods

- `values()`: Get the enum values.
- `collect()`: Get the enum values as a collection.
- `implode(string $glue = ',')`: Implode the enum values.
- `toSelectOptions()`: Get the enum values as select options.
- `keys()`: Get the enum keys.
- `readable()`: Get the enum keys in a readable format.
- `random()`: Get a random enum value.
- `toTypeScript()`: Make the enum friendly for TypeScript.
- `rules(array $extra = [])`: Make the enum friendly for validation.

Example:

```php
Status::values(); // ['active', 'inactive']
Status::collect(); // Collection of ['active', 'inactive']
Status::implode(','); // 'active,inactive'
Status::toSelectOptions(); // Collection of select options { key: 'active', value: 'Active' }, { key: 'inactive', value: 'Inactive' }
Status::keys(); // ['ACTIVE', 'INACTIVE']
Status::readable(); // ['Active', 'Inactive']
Status::random(); // 'active' or 'inactive'
Status::toTypeScript(); // ['type' => 'Status', 'values' => ['active', 'inactive']]
Status::rules(); // ['required', 'string', 'in:active,inactive']
```

## Testing

To run the tests, use the following command:

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
