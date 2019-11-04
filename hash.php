<?php
$redis = new Redis;
$redis->connect('127.0.0.1','6379');

//hmset
$arr=array('id'=>2,'name'=>'aaron','age'=>18);
$redis->hMSet('people',$arr);
print_r( $redis->hGetAll('people') );
echo "<hr>";

//hmset

print_r($redis->hMGet('people',['name','age']));
echo "<hr>";

//hdel
$redis->hDel('people','age');
print_r( $redis->hGetAll('people') );
echo "<hr>";

//hexisist
echo $redis->hExists('people','name');
echo "<hr>";

//hset
$redis->hSet('people','age',18);
echo "<hr>";

//hget
echo $redis->hGet('people','age');
echo "<hr>";

//hIncrBy
$redis->hIncrBy('people','age',20);
echo $redis->hGet('people','age');
echo "<hr>";

//hIncrByFloat
$redis->hIncrByFloat('people','age',-0.23);
echo $redis->hGet('people','age');
echo "<hr>";

//hkeys
print_r( $redis->hKeys('people'));
echo "<hr>";

//hlen
print_r($redis->hLen('people'));
echo "<hr>";

//hvals
print_r( $redis->hVals('people') );
echo "<hr>";
//hscan
$it=null;
print_r($redis->hScan('people',$it,'a*',10));
echo "<hr>";




