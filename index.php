<?php

// require "vendor/autoload.php";

// sayHello::greet("bokai");


$redis = new Redis();

$redis->connect("127.0.0.1","6379"); //php客戶端設定的ip及埠

//PING
echo $redis->ping();

echo "<hr>";

//SET
$redis->set("say","hello world");
$redis->set("myname","Aaron");

echo $redis->get("say"); //應輸出hello world
echo $redis->get("myname");

echo "<hr>";

//getrange
echo $redis->getRange('myname',0,-1);

echo "<hr>";

//DEL 
echo $redis->del('say');

echo "<hr>";

//EXISTS
echo $redis->exists('myname');

echo "<hr>";

//expire
$redis->set('test','十秒後自動消失');
$redis->expire('test','10');

echo $redis->get('test');

echo "<hr>";

//TTL
echo $redis->ttl('test');

echo "<hr>";

//keys
print_r($redis->keys('*'));
print_r($redis->keys('t*'));

echo "<hr>";


//rename
$redis->rename('test','test2');
echo $redis->get('test2');

echo "<hr>";

//type
echo $redis->TYPE('test2');

echo "<hr>";

//MSET
$arr=['gg1'=>'gg11','gg2'=>'gg22','gg3'=>'gg33'];
$redis->mset($arr);

//MGET
print_r( $redis->mget(['gg1','gg2','gg3'])) ;

echo "<hr>";
//SETEX
$redis->setex('test2',30,'232');
//等於
//set('test2','232')
//expire('test2',30)

echo $redis->ttl('test2');

echo "<hr>";

//strlen
echo $redis->strlen('test2');

echo "<hr>";

//msetnx不重複創
$arr=['gg1'=>'gg11','gg2'=>'gg22','gg3'=>'gg33'];
echo $redis->msetnx($arr);
$arr=['cc1'=>'cc11','cc2'=>'cc22','cc3'=>'cc33'];
echo $redis->msetnx($arr);
echo "<hr>";

//setnx不重複創
echo $redis->setnx('gg2','123');

echo "<hr>";

//incr
$redis->set('num',1);
$redis->incr('num');
echo $redis->get('num');
echo "<hr>";

//decr
$redis->decr('num');
echo $redis->get('num');
echo "<hr>";

//incrby
$redis->incrBy('num',20);
echo 'incrby';
echo $redis->get('num');
echo "<hr>";

//decrby
$redis->decrBy('num',20);
echo 'decrby';
echo $redis->get('num');
echo "<hr>";



//incrbyfloat
$redis->incrByFloat('num',0.5);
echo $redis->get('num');
echo "<hr>";

//decrbyfloat
$redis->incrByFloat('num',-0.5);
echo $redis->get('num');
echo "<hr>";

//append
$redis->append('gg2','ggggg22222');
echo $redis->get('gg2');
echo "<hr>";

//scan
$it=null;
print_r($redis->scan($it,'*p*',1000));






