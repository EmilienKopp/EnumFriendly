<?php

namespace Splitstack\EnumFriendly\Tests\Enums;

use Splitstack\EnumFriendly\Traits\ExtendedEnum;

enum TestStatusStr: string
{
  use ExtendedEnum;

  case PENDING = 'pending';
  case IN_PROGRESS = 'in_progress';
  case COMPLETED = 'completed';
}