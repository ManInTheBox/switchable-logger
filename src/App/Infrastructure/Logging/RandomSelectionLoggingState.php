<?php

declare(strict_types=1);

namespace App\Infrastructure\Logging;

class RandomSelectionLoggingState implements LoggingStateInterface
{
    public function isEnabled(): bool
    {
        return (bool) random_int(0, 1);
    }
}
