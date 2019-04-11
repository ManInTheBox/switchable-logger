<?php

declare(strict_types=1);

namespace App\Infrastructure\Logging;

class TimeBasedLoggingState implements LoggingStateInterface
{
    private const WAKE = 7;
    private const SLEEP = 21;

    public function isEnabled(): bool
    {
        return date('H') > self::SLEEP || date('H') < self::WAKE;
    }
}
