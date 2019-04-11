<?php

declare(strict_types=1);

namespace App\Infrastructure\Logging;

interface LoggingStateInterface
{
    public function isEnabled(): bool;
}
