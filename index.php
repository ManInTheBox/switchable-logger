<?php

include __DIR__.'/vendor/autoload.php';

use App\Infrastructure\Logging\RandomSelectionLoggingState;
use App\Infrastructure\Logging\RedisControlledLoggingState;
use App\Infrastructure\Logging\SwitchableLogger;
use App\Infrastructure\Logging\TimeBasedLoggingState;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$log = __DIR__.'/log';
$logger = new Logger('learning', [new StreamHandler($log)]);
$redis = new Redis();
$redis->connect('127.0.0.1');
$state = new RedisControlledLoggingState($redis);

(new SwitchableLogger($logger, $state))->debug('Redis works!');

$state = new RandomSelectionLoggingState();
(new SwitchableLogger($logger, $state))->debug('Random works!');

$state = new TimeBasedLoggingState();
(new SwitchableLogger($logger, $state))->debug('Time works!');

echo file_get_contents($log);
