# EnumFriendly

![Tests](https://img.shields.io/github/actions/workflow/status/emilienkopp/EnumFriendly/tests.yml?label=tests)
<!-- [![Coverage Status](https://img.shields.io/coveralls/github/emilienkopp/EnumFriendly/main.svg?style=flat-square)](https://coveralls.io/github/emilienkopp/EnumFriendly?branch=main) -->
![PHP Version](https://img.shields.io/badge/php-^8.1-blue.svg?style=flat-square)
![Laravel Version](https://img.shields.io/badge/laravel-^11.0-orange.svg?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/splitstack/laravel-enum-friendly.svg?style=flat-square)](https://packagist.org/packages/splitstack/laravel-enum-friendly)

## Introduction

EnumFriendly is a powerful PHP package that enhances your Laravel application's enum experience. It provides a friendly interface for working with enums, making them more versatile and easier to integrate with TypeScript, forms, translations, and more.

With EnumFriendly, you can:
- Generate enum classes with a simple artisan command
- Convert enum values to TypeScript types
- Create form-friendly select options
- Generate validation rules automatically
- Access readable labels and collections
- And much more!

## Installation

You can install the package via composer:

```bash
composer require splitstack/laravel-enum-friendly
```

The package will automatically register its service provider.

## Usage

### Creating a Friendly Enum

You can use the `MakeFriendlyEnum` command to create a new friendly enum:

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

The `ExtendedEnum` trait provides additional methods for your enums (string-backed, int-backed, or plain):

```php
use Splitstack\EnumFriendly\Traits\ExtendedEnum;

enum MyEnum: string
{
  use ExtendedEnum;

  case ADMIN = 'admin';
  case USER = 'user';
}
```

#### Available Methods

| Method | Description | Example Output |
|--------|-------------|----------------|
| `values()` | Get the enum values | `['active', 'inactive']` |
| `collect()` | Get the enum values as a collection | Collection of `['active', 'inactive']` |
| `implode(string $glue = ',')` | Implode the enum values | `'active,inactive'` |
| `toSelectOptions()` | Get the enum values as select options | `[['value' => 'active', 'label' => 'Active'], ...]` |
| `keys()` | Get the enum keys | `['ACTIVE', 'INACTIVE']` |
| `readable()` | Get the enum keys in a readable format | `['Active', 'Inactive']` |
| `random()` | Get a random enum value | `'active'` or `'inactive'` |
| `toTypeScript()` | Make the enum friendly for TypeScript | `['type' => 'Status', 'values' => [...]]` |
| `rules(array $extra = [])` | Make the enum friendly for validation | `['required', 'string', 'in:active,inactive']` |

### TypeScript Integration

The `toTypeScript()` method generates TypeScript-friendly type definitions:

```php
Status::toTypeScript();
// Returns:
// [
//   'type' => 'Status',
//   'values' => ['active', 'inactive']
// ]
```

### Form Integration

Create select options for your forms easily:

```php
Status::toSelectOptions();
// Returns:
// [
//   ['value' => 'active', 'label' => 'Active'],
//   ['value' => 'inactive', 'label' => 'Inactive']
// ]
```

### Validation Rules

Generate Laravel validation rules automatically:

```php
Status::rules(['required']);
// Returns: ['required', 'string', 'in:active,inactive']
```

## Testing

Run the test suite:

```bash
composer test
```

Generate test coverage report:

```bash
composer test:coverage
```

## Contributing

Contributions are welcome! Feel free to:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- [EmilienKopp](https://github.com/emilienkopp)
- [All Contributors](../../contributors)
