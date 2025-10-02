<?php

namespace Splitstack\EnumFriendly\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Splitstack\EnumFriendly\Traits\EnumFriendly;

/**
 * LaravelEnumFriendly Trait
 * 
 * Extends the core EnumFriendly trait with Laravel-specific functionality
 * including Collections, validation rules, and Laravel helper integrations.
 * 
 * @author Emilien Kopp
 * @package Splitstack\EnumFriendly\Traits
 */
trait ExtendedEnum
{
    use EnumFriendly;

    /**
     * Get enum values as a Laravel Collection.
     * 
     * Provides a fluent interface for working with enum values using
     * Laravel's Collection methods.
     *
     * @return \Illuminate\Support\Collection<int, string|int> Collection of enum values
     * 
     * @example
     * UserStatus::collect()->filter(fn($status) => $status !== 'inactive')
     */
    public static function collect(): Collection
    {
        return collect(self::values());
    }

    /**
     * Convert enum cases to select option format as a Laravel Collection.
     * 
     * Wraps the core trait's toSelectOptionsArray() method and returns a Laravel Collection
     * instead of a plain array for fluent interface support.
     *
     * @return \Illuminate\Support\Collection<int, array{value: string|int, label: string, name: string}> 
     *         Collection of select options
     * 
     * @example
     * UserStatus::toSelectOptionsCollection()->filter(fn($option) => $option['value'] !== 'inactive')
     */
    public static function toSelectOptions(): Collection
    {
        return collect(self::toOptionsArray());
    }

    /**
     * Generate Laravel validation rules for the enum.
     * 
     * Creates an array of validation rules that can be used with Laravel's
     * validator. Includes 'string' and 'in:' rules by default, with support
     * for additional custom rules.
     *
     * @param array<string> $extra Additional validation rules to merge
     * @return array<string> Array of validation rules
     * 
     * @example
     * UserStatus::rules() // Returns ['string', 'in:active,inactive,pending']
     * UserStatus::rules(['required']) // Returns ['required', 'string', 'in:active,inactive,pending']
     */
    public static function rules(array $extra = []): array
    {
        return array_merge($extra, ['string', 'in:' . self::implode()]);
    }

    /**
     * Get Laravel's enum validation rule instance.
     * 
     * Returns a Laravel Enum validation rule instance that can be used
     * in form requests or manual validation.
     *
     * @return \Illuminate\Validation\Rules\Enum Laravel enum validation rule
     * 
     * @example
     * // In a form request
     * 'status' => ['required', UserStatus::rule()]
     */
    public static function rule(): Enum
    {
        return new Enum(self::class);
    }
}