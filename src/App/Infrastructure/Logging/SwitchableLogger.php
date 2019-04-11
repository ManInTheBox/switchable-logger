<?php

declare(strict_types=1);

namespace App\Infrastructure\Logging;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

final class SwitchableLogger extends AbstractLogger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var LoggingStateInterface
     */
    private $loggingState;

    public function __construct(LoggerInterface $logger, LoggingStateInterface $loggingState)
    {
        $this->logger = $logger;
        $this->loggingState = $loggingState;
    }

    public function log($level, $message, array $context = [])
    {
        if (!$this->loggingState->isEnabled()) {
            return;
        }

        $this->logger->log($level, $message, $context);
    }
}
