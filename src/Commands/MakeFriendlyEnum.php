<?php

namespace Splitstack\EnumFriendly\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
enum Casing: string
{
  case Pascal = 'Pascal';
  case UPPER = 'UPPER';
  case lower = 'lower';
}

class MakeFriendlyEnum extends Command
{
  protected $signature = 'split:enum {name} 
    {--type= : string or int, the backed type}
    {--u|upper : Convert the case name to uppercase}
    {values*}
  ';

  protected $description = 'Create a new friendly enum';

  public function handle()
  {
    $name = $this->argument('name');
    $values = $this->argument('values');
    $type = $this->option('type');
    $isUpper = $this->option('upper');

    $stub = file_get_contents(__DIR__ . '/stubs/friendly-enum.stub');

    $cases = collect($values)->map(function ($value) use ($type, $isUpper) {
      $split = explode(':', $value);
      $const = $isUpper ? strtoupper($split[0]) : $split[0];
      $value = $split[1] ?? $split[0];

      if ($type === 'int') {
        if (!is_numeric($value)) {
          $v = json_encode($value);
          throw new \InvalidArgumentException("Value `{$v}` is not a number");
        }
        $value = (int) $value;
      }

      $case = "  case {$const}";

      if ($type === 'string') {
        $case .= " = '{$value}'";
      } else if ($type === 'int') {
        $case .= " = {$value}";
      }


      return "{$case};";
    })->implode("\n");

    $content = str_replace(
      ['{{ name }}', '{{ cases }}', '{{ type }}'],
      [$name, $cases, $type ? ": $type" : ''],
      $stub
    );

    $path = app_path("Enums/{$name}.php");

    if (!is_dir(dirname($path))) {
      mkdir(dirname($path), 0777, true);
    }

    file_put_contents($path, $content);

    $this->info("Friendly enum {$name} created successfully!");
  }
}