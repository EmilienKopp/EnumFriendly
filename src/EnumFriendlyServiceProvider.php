<?php


namespace Splitstack\EnumFriendly;

use Illuminate\Support\ServiceProvider;
use Splitstack\EnumFriendly\Commands\MakeFriendlyEnum;

class EnumFriendlyServiceProvider extends ServiceProvider
{
    public function boot() {
      if($this->app->runningInConsole()) {
        $this->commands([
          MakeFriendlyEnum::class
        ]);
      }
    }

    public function register() {
      // ...
    }
}