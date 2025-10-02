# EnumFriendly for Laravel

![Tests](https://img.shields.io/github/actions/workflow/status/emilienkopp/EnumFriendly/tests.yml?label=tests)
<!-- [![Coverage Status](https://img.shields.io/coveralls/github/emilienkopp/EnumFriendly/main.svg?style=flat-square)](https://coveralls.io/github/emilienkopp/EnumFriendly?branch=main) -->
![PHP Version](https://img.shields.io/badge/php-^8.1-blue.svg?style=flat-square)
![Laravel Version](https://img.shields.io/badge/laravel-^11.0-orange.svg?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/splitstack/laravel-enum-friendly.svg?style=flat-square)](https://packagist.org/packages/splitstack/laravel-enum-friendly)

## Introduction

EnumFriendly for Laravel is a powerful PHP package that enhances your Laravel application's enum experience. Built on top of the dependency-free [EnumFriendly Core](https://github.com/EmilienKopp/EnumFriendlyCore), it provides Laravel-specific features like Collections, validation rules, and Artisan commands while maintaining all the core functionality.

**🚀 Key Features:**
- **Laravel Collections Integration** - Many methods return Laravel Collections for fluent chaining
- **Artisan Commands** - Generate enum classes with a simple command
- **Laravel Validation** - Automatic validation rule generation and Laravel Rule integration  
- **Comprehensive Enum Utilities** - Over 25 helpful methods for enum manipulation
- **TypeScript Integration** - Generate TypeScript-compatible type definitions
- **Form Integration** - Ready-made select options with Laravel Collections
- **Developer Friendly** - Intuitive API with extensive documentation

With EnumFriendly for Laravel, you can:
- Generate enum classes with a simple artisan command
- Convert enum values to TypeScript types
- Create form-friendly select options with Laravel Collections
- Generate Laravel validation rules automatically
- Access readable labels and collections
- Use all core EnumFriendly features with Laravel enhancements
- And much more!

## Installation

You can install the package via composer:

```bash
composer require splitstack/laravel-enum-friendly
```

The package will automatically register its service provider and install the dependency-free core package.

## Laravel-Specific Features

### Artisan Commands

Generate enum classes with the `MakeFriendlyEnum` command:

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

### Laravel Collections Integration

The Laravel package extends several core methods to return Laravel Collections instead of arrays:

```php
// Returns Laravel Collection instead of array
Status::collect(); // Collection of ['active', 'inactive']
Status::toSelectOptions(); // Collection of select option arrays
```

### Laravel Validation Rules

Generate Laravel validation rules automatically:

```php
Status::rules(['required']);
// Returns: ['required', 'string', 'in:active,inactive']

// Or get a Laravel Rule instance
Status::rule();
// Returns: Illuminate\Validation\Rules\Enum instance
```

## Usage

### Adding the ExtendedEnum Trait

Simply add the `ExtendedEnum` trait to your existing enums to unlock all the enhanced functionality:

```php
<?php

use Splitstack\EnumFriendly\Traits\ExtendedEnum;

enum UserStatus: string
{
    use ExtendedEnum;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
    case SUSPENDED = 'suspended';
}

enum Priority: int
{
    use ExtendedEnum;

    case LOW = 1;
    case MEDIUM = 2;
    case HIGH = 3;
    case CRITICAL = 4;
}

enum Color
{
    use ExtendedEnum;

    case RED;
    case GREEN;
    case BLUE;
}
```

## Available Methods

The `ExtendedEnum` trait provides all core functionality plus Laravel-specific enhancements:

### Core Methods (inherited from EnumFriendly Core)

| Method | Description | Example Output |
|--------|-------------|----------------|
| `values()` | Get all enum values (or names for unbacked) | `['active', 'inactive']` |
| `keys()` | Get all enum case names | `['ACTIVE', 'INACTIVE']` |
| `readable()` | Get case names in human-readable format | `['Active', 'Inactive']` |
| `implode(string $glue = ',')` | Implode the enum values | `'active,inactive'` |
| `toOptionsArray()` | Get enum as form select options array | `[['value' => 'active', 'label' => 'Active'], ...]` |
| `toReadableArray()` | Get enum as value => readable label mapping | `['active' => 'Active', 'inactive' => 'Inactive']` |
| `toArray()` | Get enum as value => case name mapping | `['active' => 'ACTIVE', 'inactive' => 'INACTIVE']` |
| `toJsonArray()` | Get enum as case name => value mapping | `['ACTIVE' => 'active', 'INACTIVE' => 'inactive']` |
| `random()` | Get a random enum value | `'active'` or `'inactive'` |
| `randomCase()` | Get a random enum case instance | `MyEnum::ACTIVE` or `MyEnum::INACTIVE` |
| `coerceEnum($value)` | Safely convert value to enum instance | `MyEnum::ACTIVE` or `null` |
| `coerceValue($value)` | Safely convert value to enum value | `'active'` or `null` |
| `hasValue($value)` | Check if value exists in enum | `true` or `false` |
| `only($cases)` | Filter enum cases by names | `[MyEnum::ACTIVE]` |
| `onlyValues($values)` | Filter enum values by values | `['active', 'pending']` |
| `except($cases)` | Exclude enum cases by names | `[MyEnum::INACTIVE]` |
| `exceptValues($values)` | Exclude enum values by values | `['pending', 'completed']` |
| `count()` | Get total number of enum cases | `2` |
| `isBacked()` | Check if enum is backed | `true` or `false` |
| `toTypeScript()` | Make enum TypeScript-friendly | `['type' => 'MyEnum', 'values' => [...]]` |
| `comment($prefix)` | Generate descriptive comment | `'possible values: active, inactive'` |
| `toJson($options)` | Convert to JSON string | `'{"active":"ACTIVE","inactive":"INACTIVE"}'` |
| `fromValueOr($value, $default)` | Get enum with fallback | `MyEnum::ACTIVE` or `$default` |
| `label()` | Get human-readable label for instance | `'Active'` (when called on enum instance) |
| `description()` | Get description if implemented | Custom description or `null` |
| `is($value)` | Compare enum instance with value | `true` or `false` |
| `in($values)` | Check if enum instance is in array | `true` or `false` |

### Laravel-Enhanced Methods

| Method | Description | Laravel Enhancement |
|--------|-------------|-------------------|
| `collect()` | Get enum values as Laravel Collection | Returns `Collection` instead of array |
| `toSelectOptions()` | Get enum as select options | Returns `Collection` instead of array |
| `rules(array $extra = [])` | Generate Laravel validation rules | Laravel-specific validation format |
| `rule()` | Get Laravel Enum validation rule | Returns `Illuminate\Validation\Rules\Enum` |

## Common Usage Examples

### TypeScript Integration

Generate TypeScript-compatible type definitions:

```php
UserStatus::toTypeScript();
// Returns:
// [
//   'type' => 'UserStatus',
//   'values' => ['active', 'inactive', 'pending', 'suspended']
// ]
```

### Form Integration

Create select options for your Laravel forms:

```php
// Returns Laravel Collection of select options
UserStatus::toSelectOptions();
// Collection [
//   ['value' => 'active', 'label' => 'Active', 'name' => 'Active'],
//   ['value' => 'inactive', 'label' => 'Inactive', 'name' => 'Inactive'],
//   ['value' => 'pending', 'label' => 'Pending', 'name' => 'Pending'],
//   ['value' => 'suspended', 'label' => 'Suspended', 'name' => 'Suspended']
// ]

// Use in Blade templates
@foreach(UserStatus::toSelectOptions() as $option)
    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
@endforeach
```

### Laravel Validation

```php
// In a Form Request
public function rules()
{
    return [
        'status' => UserStatus::rules(['required']),
        // Returns: ['required', 'string', 'in:active,inactive,pending,suspended']
        
        'priority' => ['required', Priority::rule()],
        // Uses Laravel's built-in Enum validation rule
    ];
}
```

### Safe Value Coercion

Safely convert unknown values to enum instances:

```php
// Safe conversion - returns enum instance or null
$status = UserStatus::coerceEnum('active'); // Returns UserStatus::ACTIVE
$invalid = UserStatus::coerceEnum('invalid'); // Returns null

// With fallback
$status = UserStatus::fromValueOr('invalid', UserStatus::PENDING); // Returns UserStatus::PENDING

// Check if value exists
UserStatus::hasValue('active'); // Returns true
UserStatus::hasValue('invalid'); // Returns false
```

### Working with Laravel Collections

Filter and manipulate enum cases using Laravel Collections:

```php
// Get enum values as a Collection for fluent operations
UserStatus::collect()
    ->filter(fn($status) => $status !== 'suspended')
    ->map(fn($status) => strtoupper($status))
    ->implode(', ');

// Get only specific cases
$activeCases = UserStatus::only(['ACTIVE', 'PENDING']);

// Exclude specific cases  
$nonSuspendedCases = UserStatus::except(['SUSPENDED']);

// Filter by values - returns array of values
$validStatuses = UserStatus::onlyValues(['active', 'pending']);

// Get random values for testing
$randomStatus = UserStatus::random(); // Returns a random value
$randomCase = UserStatus::randomCase(); // Returns a random enum instance
```

### Instance Methods

Use methods directly on enum instances:

```php
$status = UserStatus::ACTIVE;

$status->label(); // Returns 'Active'
$status->is('active'); // Returns true
$status->is(UserStatus::INACTIVE); // Returns false
$status->in(['active', 'pending']); // Returns true

// Custom descriptions (if you implement getDescription() method)
$status->description(); // Returns custom description or null
```

## Why Choose EnumFriendly for Laravel?

### 🚀 **Built on Solid Foundation**
Based on the dependency-free EnumFriendly Core package, ensuring stability and performance.

### 🔧 **Laravel-Optimized**
- **Collections Integration** - Seamless integration with Laravel's Collection class
- **Validation Rules** - Native Laravel validation rule generation
- **Artisan Commands** - Generate enums with Laravel's command system

### 📦 **Zero Configuration**
- Auto-discovery service provider
- Works immediately after installation
- No configuration files needed

### 🎯 **Developer Experience**
- **Intuitive API** - Methods named exactly what they do
- **Comprehensive documentation** - Every method documented with examples
- **IDE friendly** - Full type hints and auto-completion for Laravel
- **Extensive test coverage** - 25+ tests covering all functionality

### 🔄 **Migration Friendly**
Easy to integrate into existing Laravel projects:
```php
// Before
$values = array_column(MyEnum::cases(), 'value');

// After
$values = MyEnum::collect(); // Laravel Collection!
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

## Related Packages

- **[EnumFriendly Core](https://github.com/EmilienKopp/EnumFriendlyCore)** - The dependency-free core package that powers this Laravel integration
