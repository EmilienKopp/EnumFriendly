<?php

namespace Splitstack\EnumFriendly\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait ExtendedEnum
{
  /**
   * Get the enum values.
   *
   * @return array
   */
  public static function values(): array
  {
    $cases = self::cases();
    $columns = array_column($cases, 'value');
    if (empty($columns)) {
      return array_column(self::cases(), 'name');
    }
    return array_column(self::cases(), 'value');
  }

  public static function collect(): \Illuminate\Support\Collection
  {
    return collect(self::values());
  }

  public static function implode(string $glue = ','): string
  {
    return implode($glue, self::values());
  }

  public static function toSelectOptions(): \Illuminate\Support\Collection
  {
    $cases = collect(self::cases());
    return $cases->map(function ($obj) {
      $name = $obj->name;
      if(property_exists($obj, 'value')) {
        $value = $obj->value;
      } else {
        $value = null;
      }
      $readable = self::toReadable($name);
      return [
        'value' => $value ?? $name,
        'label' => $readable,
        'name' => $readable,
      ];
    });
  }

  /**
   * Get the enum keys.
   *
   * @return array
   */
  public static function keys(): array
  {
    return collect(self::cases())->map(function ($obj) {
      return $obj->name;
    })->toArray();
  }

  public static function readable(): array
  {
    return array_map(function ($key) {
      return self::toReadable($key);
    }, self::keys());
  }

  public static function random(): string|int
  {
    return Arr::random(self::values());
  }

  private static function toReadable($key): string
  {
    return Str::title(Str::replace('_', ' ', $key));
  }

  /**
   * Make the enum friendly for TypeScript
   */
  public static function toTypeScript(): array
  {
    return [
      'type' => explode('\\',self::class)[count(explode('\\',self::class)) - 1],
      'values' => self::values(),
    ];
  }

  /**
   * Make the enum friendly for validation
   */
  public static function rules(array $extra = []): array
  {
    return array_merge(['string', 'in:' . self::implode()], $extra);
  }


}
