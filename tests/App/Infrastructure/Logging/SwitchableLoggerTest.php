<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Logging;

use App\Infrastructure\Logging\LoggingStateInterface;
use App\Infrastructure\Logging\SwitchableLogger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class SwitchableLoggerTest extends TestCase
{
    public function testStateDisabled(): void
    {
        $message = 'It works!';

        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log('info', $message, [])->shouldNotBeCalled();
        $state = $this->prophesize(LoggingStateInterface::class);
        $state->isEnabled()->willReturn(false);

        (new SwitchableLogger($logger->reveal(), $state->reveal()))->info($message);
    }

    public function testStateEnabled(): void
    {
        $message = 'It works!';

        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log('info', $message, [])->shouldBeCalled();
        $state = $this->prophesize(LoggingStateInterface::class);
        $state->isEnabled()->willReturn(true);

        (new SwitchableLogger($logger->reveal(), $state->reveal()))->info($message);
    }
}
