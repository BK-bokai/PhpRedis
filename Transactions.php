<?php
$redis= new Redis;
$redis->connect('127.0.0.1','6379');

$redis->watch('Aaron');//啟動監聽
//如果監聽的key在排隊期間被其他客戶端修改，則exec就會回傳nil並取消所有動作
$redis->unwatch();
//也可以取消監聽;
$redis->multi();//啟動排隊
print_r($redis->set('Aaron','handsome',60));
echo "<br>";
print_r($redis->zAdd('Perla',2,'高'));
echo "<br>";
print_r($redis->zAdd('Perla',3,'矮'));
echo "<br>";
print_r($redis->zAdd('Perla',3,'胖'));
echo "<br>";
print_r($redis->rPush('bruce','天'));
echo "<br>";
print_r($redis->rPush('bruce','氣'));
echo "<br>";

print_r($redis->get('Aaron'));
echo "<br>";
print_r($redis->zRange('Perla',0,-1,true));
echo "<br>";
print_r($redis->lRange('bruce',0,-1));
echo "<br>";

// print_r($redis->discard());//取消排隊內的所有事情
print_r($redis->exec());//執行排隊內所有事情


?>