<?php

declare(strict_types=1);

namespace App\Infrastructure\Logging;

class NightShiftLoggingState implements LoggingStateInterface
{
    private const START = 21;
    private const END = 7;

    public function isEnabled(): bool
    {
        return date('H') >= self::START || date('H') <= self::END;
    }
}
