<?php

namespace Splitstack\EnumFriendly\Tests\Enums;

use Splitstack\EnumFriendly\Traits\ExtendedEnum;

enum TestStatusUnbacked
{
  use ExtendedEnum;

  case PENDING;
  case IN_PROGRESS;
  case COMPLETED;
}
