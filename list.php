<?php
$redis = new Redis;
echo $redis->connect('127.0.0.1','6379');

//PUSH Lrange
$redis->lPush('test_L','no1');
$redis->rPush('test_L','no2');

print_r($redis->lRange('test_L',0,-1));
echo "<hr>";

//blpop
print_r($redis->blPop('test_L',10));//當key不存在系統就會阻塞10秒，若不為空則會返回list的第一個元素;
echo "<hr>";
//brpop
print_r($redis->brPop('test_L',10));//當key不存在系統就會阻塞10秒，若不為空則會返回list的最後個元素;
echo "<hr>";

//brpoplpush
print_r($redis->brpoplpush('test_L','test2_L',3));//當第一個list存在時，會將第一個list的最後一個元素插入第二個list的頭，若第一個list不存在則阻塞。
echo "<hr>";

//lindex
print_r($redis->lIndex('test2_L',1));//獲取指定的值
echo "<hr>";

//llen
print_r($redis->lLen('test2_L'));
echo "<hr>";

//lpop Returns and removes the first element of the list.
print_r($redis->lPop('test_L'));
echo "<hr>";

//rpop Returns and removes the last element of the list.
print_r($redis->rPop('test_L'));
echo "<hr>";

//lpushx 
$redis->lPushx('test2_L',123);//指插入存在的列表，並插在頭
print_r($redis->lRange('test2_L',0 ,-1));
echo "<hr>";

//rpushx 
$redis->rPushx('test2_L',123);//指插入存在的列表，並插在尾
print_r($redis->lRange('test2_L',0 ,-1));
echo "<hr>";

//lRem
// $redis->lRem(string $key, string $value, int $count);
// count > 0 : 从表头开始向表尾搜索，移除与 VALUE 相等的元素，数量为 COUNT 。
// count < 0 : 从表尾开始向表头搜索，移除与 VALUE 相等的元素，数量为 COUNT 的绝对值。
// count = 0 : 移除表中所有与 VALUE 相等的值。
$redis->lRem('test2_L','no2',0);
print_r($redis->lRange('test2_L',0 ,-1));
echo "<hr>";
//lset
$redis->lSet('test2_L',0,'我是被插在位置0的值');
print_r($redis->lRange('test2_L',0 ,-1));
echo "<hr>";

//ltrim， 让列表只保留指定区间内的元素，不在指定区间之内的元素都将被删除。
$redis->lTrim('test2_L',2,-1);
print_r($redis->lRange('test2_L',0 ,-1));
echo "<hr>";

//rpoplpush將前面list第一個元素最後一個值刪除，並將他加到後面list最後一個元素
$redis->rpoplpush('test2_L','test3_L');

?>