<?php

include __DIR__.'/vendor/autoload.php';

use App\Infrastructure\Logging\NightShiftLoggingState;
use App\Infrastructure\Logging\RandomSelectionLoggingState;
use App\Infrastructure\Logging\RedisControlledLoggingState;
use App\Infrastructure\Logging\SwitchableLogger;
use Psr\Log\AbstractLogger;

$logger = new class extends AbstractLogger {
    public $logs = [];

    public function log($level, $message, array $context = [])
    {
        $this->logs[] = ['level' => $level, 'message' => $message, 'context' => $context];
    }
};

$redis = new Redis();
$redis->connect('127.0.0.1');
$state = new RedisControlledLoggingState($redis);
(new SwitchableLogger($logger, $state))->warning('Redis works!');

$state = new RandomSelectionLoggingState();
(new SwitchableLogger($logger, $state))->info('Random works!');

$state = new NightShiftLoggingState();
(new SwitchableLogger($logger, $state))->debug('Night shift works!');

var_dump($logger->logs);

/*
$ redis-server &
$ redis-cli
127.0.0.1:6379> set logging.enabled 1
OK
$ php index.php                                                                                                                                               [22:55:54]
array(2) {
  [0] =>
  array(3) {
    'level' =>
    string(7) "warning"
    'message' =>
    string(12) "Redis works!"
    'context' =>
    array(0) {
    }
  }
  [1] =>
  array(3) {
    'level' =>
    string(5) "debug"
    'message' =>
    string(18) "Night shift works!"
    'context' =>
    array(0) {
    }
  }
}
*/
