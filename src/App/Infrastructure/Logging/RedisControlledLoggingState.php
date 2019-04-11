<?php

declare(strict_types=1);

namespace App\Infrastructure\Logging;

use Redis;

class RedisControlledLoggingState implements LoggingStateInterface
{
    private const REDIS_KEY = 'logging.enabled';

    /**
     * @var Redis
     */
    private $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function isEnabled(): bool
    {
        return (bool) $this->redis->get(self::REDIS_KEY);
    }
}
