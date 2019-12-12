<?php
$redis = new Redis;
$redis->connect('127.0.0.1','6379');

// $redis->subscribe(['redisChat'],function ($redis, $chan, $msg) {
//     var_dump($redis);
//     var_dump($chan);
//     var_dump($msg);
// });

$redis->subscribe(['redisChat'],'callback');

function callback($instance, $channelName, $message) {
    echo $channelName, "==>", $message,PHP_EOL;
}
// var_dump($redis);
?>