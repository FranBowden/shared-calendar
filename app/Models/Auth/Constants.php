<?php

namespace App\Models\Auth;

class Constants
{
  /**
   * Failed attempts allowed before the throttle kicks in.
   */
  public const MAX_ATTEMPTS = 5;

  /**
   * How long a locked-out key stays locked, in seconds.
   */
  public const DECAY_SECONDS = 60;
}
