<?php

namespace Splitstack\EnumFriendly\Tests\Enums;

use Splitstack\EnumFriendly\Traits\ExtendedEnum;

enum TestStatusInt: int
{
  use ExtendedEnum;

  case PENDING = 1;
  case IN_PROGRESS = 2;
  case COMPLETED = 3;
}