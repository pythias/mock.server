<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Tarth\Task\AbstractTask;
use Tarth\Tool\Redis;

function init($worker) {
    Redis::setCacheServer(Core_Config::get('redis.tarth_cache', '127.0.0.1:6379'));
    Redis::setQueueServer(Core_Config::get('redis.tarth_queue', '127.0.0.1:6379'));
}

function run($worker, $data) {
    if ($data == false) {
        return false;
    }
    
    $task = AbstractTask::createTask(json_decode($data, true));
    return $task->run();
}

function complete($worker) {
    
}