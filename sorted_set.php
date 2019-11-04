<?php
$redis = new Redis;
$redis->connect("127.0.0.1","6379");

//zadd就是add
$redis->zAdd('myset',1,'first');
$redis->zAdd('myset',2,'second');
$redis->zAdd('myset',3,'third');
$redis->zAdd('myset',2,'forth');
print_r($redis->zRange('myset',0,-1));
echo '<br>';
print_r($redis->zRange('myset',0,-1,true));
echo '<hr>';

//zcard顯示成員數
print_r($redis->zCard('myset'));
echo '<hr>';

//zcount顯示所指定分數內的成員數
print_r($redis->zCount('myset',0,2));
echo '<hr>';

//zIncrBy對成員的分數進行加減分
print_r($redis->zRange('myset',0,-1,true));
echo '<br>';
$redis->zIncrBy('myset',2,'second');
echo '<br>';
print_r($redis->zRange('myset',0,-1,true));
echo '<hr>';

// zInterStore($output, $zSetKeys, array $weights = null, $aggregateFunction = 'SUM')找出聯集
// output是你要儲存的set
// zSetKey將兩個set用array包起來
// $weight將兩個set乘上各自的權重，[2,5]就是前面set*2，後面set*5
// $aggregateFunction 你要採取什麼行動，sum就是相加，min就是兩者取權重找小的，max兩者取完全重後取大的
$redis->zAdd('mid_exam',40,'aaron');
$redis->zAdd('mid_exam',40,'perla');
$redis->zAdd('mid_exam',40,'bluce');
$redis->zAdd('mid_exam',40,'jack');

$redis->zAdd('fin_exam',45,'aaron');
$redis->zAdd('fin_exam',46,'perla');
$redis->zAdd('fin_exam',44,'bluce');
$redis->zAdd('fin_exam',48,'jack');



$redis->zInterStore('sun_exam', array('mid_exam', 'fin_exam'), [2,5],'sum');
print_r($redis->zRange('sun_exam',0,-1,true));
echo '<hr>';
// //zRangeByLex先按照分數排在按照字母排,-是無限小,+是無限大，(無包含，[有包含

// print_r($redis->zRangeByLex('sun_exam','-','+'));//这里的-相当于负无穷大，+相当于正无穷大，这个命令相当于返回key为myzset的有序集合的所有元素;
// echo '<br>';
// print_r($redis->zRangeByLex('sun_exam','[aaron','+'));//從a開始不包含aaron，分數只要大於a，且字母為b~z就符合規則。
// echo '<br>';
// print_r($redis->zRangeByLex('sun_exam','-','[j'));//從a開始不包含aaron，分數只要大於a，且字母為b~z就符合規則。
// echo '<br>';
// print_r($redis->zRangeByLex('sun_exam','-','[bluce'));//從-無限大開始，分數只要小於bluce，且字母為a~bluce就符合規則。

//zRangeByScore
print_r($redis->zRangeByScore('sun_exam',304,330));
echo '<br>';
// $redis->zRangeByScore('key', 0, 3, ['withscores' => TRUE]); /* ['val0' => 0, 'val2' => 2] */
// $redis->zRangeByScore('key', 0, 3, ['limit' => [1, 1]]); /* ['val2'] */
// $redis->zRangeByScore('key', 0, 3, ['withscores' => TRUE, 'limit' => [1, 1]]); /* ['val2' => 2] */
print_r($redis->zRangeByScore('sun_exam',304,330,['withscores' => TRUE]));
echo '<br>';
//limit => [$offset, $count]
print_r($redis->zRangeByScore('sun_exam',304,330,['withscores' => TRUE,'limit' => [0, 2]]));
echo '<hr>';

//zRank顯示排名
print_r($redis->zRank('sun_exam','bluce'));
echo '<hr>';

//zRem移除一個或多個成員
print_r($redis->zRange('sun_exam',0,-1));
echo '<br>';
print_r($redis->zRem('sun_exam','aaron'));
echo '<br>';
print_r($redis->zRange('sun_exam',0,-1));
echo '<hr>';

//zRemRangeByScore刪除分數區間內的成員
print_r($redis->zRange('sun_exam',0,-1));
echo '<br>';
print_r($redis->zRemRangeByScore('sun_exam',300,310));
echo '<br>';
print_r($redis->zRange('sun_exam',0,-1));
echo '<hr>';

//zRemRangeByRank刪除排名區間內的成員
print_r($redis->zRange('sun_exam',0,-1));
echo '<br>';
print_r($redis->zRemRangeByRank('sun_exam',0,1));
echo '<br>';
print_r($redis->zRange('sun_exam',0,-1));
echo '<hr>';

//zRevRange回傳分數從大到小排列的反矩陣
print_r($redis->zRevRange('fin_exam',0,-1,true));
echo '<hr>';

//zRevRangeByScore回傳分數從大到小排列的反矩陣
print_r($redis->zRevRangeByScore('fin_exam',46,44,['withscores' => TRUE]));
echo '<hr>';

//zScore回傳成員分數
print_r($redis->zScore('fin_exam','aaron'));
echo '<hr>';

//結合兩個集合zUnionStore($output, $zSetKeys, array $weights = null, $aggregateFunction = 'SUM')
// output是你要儲存的set
// zSetKey將兩個set用array包起來
// $weight將兩個set乘上各自的權重，[2,5]就是前面set*2，後面set*5
// $aggregateFunction 你要採取什麼行動，sum就是相加，min就是兩者取權重找小的，max兩者取完全重後取大的
$redis->zUnionStore('result',array('mid_exam', 'fin_exam'),[2,5],'sum');
print_r($redis->zRange('result',0,-1,true));
echo '<hr>';


//zscan第一個參數是集合，第二個為null，第三個為你要找的訊息，

$it=null;
print_r($redis->zScan('result',$it,'*a*'));
?>