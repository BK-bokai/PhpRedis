<?php
$redis=new Redis ;
$redis->connect("127.0.0.1","6379"); 

$keys=$redis->keys('*');
// print_r($keys);

foreach ($keys as $key => $value) {
    echo $value;
    $redis->del($value);
}
?>