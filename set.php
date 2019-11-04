<?php
$redis=new Redis;
$redis->connect("127.0.0.1","6379"); //php客戶端設定的ip及埠

//sAdd裡面不會有重複的內容。
$redis->set('myset','hello');//這樣的type為字串;
$redis->sAdd('people','aaron');//這樣的type為set 集合;
$redis->sAdd('people','perla');//再加一個人名;
$redis->sAdd('people','perlas');//再加一個人名;
$redis->sAdd('people','perlaa');//再加一個人名;
$redis->sAdd('people','perladf');//再加一個人名;
$redis->sAdd('people','perlaa');//再加一個人名;
$redis->sAdd('people','aaron');//若有重複則不會在加
$redis->sAdd('people','candy');//若有重複則不會在加
print_r($redis->sMembers('people'));
echo "<hr>";




//scard返回元素數目
print_r($redis->sCard('people'));
echo "<hr>";

//sdiff只取出people資料表中不包含與2people、3people資料表內相同的資料(差集)
$redis->sAdd('2people','aaron');
$redis->sAdd('2people','apple');
$redis->sAdd('2people','butcher');
$redis->sAdd('2people','micho');

$redis->sAdd('3people','aaron');
$redis->sAdd('3people','perla');
$redis->sAdd('3people','butcher');
$redis->sAdd('3people','micho');
print_r($redis->sDiff('people','2people','3people'));
echo "<hr>";

//sDiffStore给定集合之间的差集存储在指定的集合中。如果指定的集合 key 已存在，则会被覆盖。
$redis->sDiffStore('diffStore','people','2people','3people');
print_r($redis->sMembers('diffStore'));
echo "<hr>";

//sinter交集
print_r($redis->sInter('people','2people','3people'));
echo "<hr>";

//sinterstore给定集合之间的交集存储在指定的集合中。如果指定的集合已经存在，则将其覆盖。
$redis->sInterStore('interStore','people','2people','3people');
print_r($redis->sMembers('interStore'));
echo "<hr>";

//sismembers
echo $redis->sIsMember('people','aaron') ? "aaron 是 people 的成員": "不是";
echo "<hr>";
echo $redis->sIsMember('people','apple') ? "apple 是 people 的成員": "不是";
echo "<hr>";

//move如果 source 集合不存在或不包含指定的 member 元素，则 SMOVE 命令不执行任何操作，仅返回 0 。
//否则， member 元素从 source 集合中被移除，并添加到 destination 集合中去。

//当 destination 集合已经包含 member 元素时， SMOVE 命令只是简单地将 source 集合中的 member 元素删除。

//当 source 或 destination 不是集合类型时，返回一个错误。
$redis->sMove('3people','people','butcher');
print_r($redis->sMembers('3people'));
echo "<br>";
print_r($redis->sMembers('people'));
echo "<hr>";

// //spop隨機返回集合內的元素並刪除，
// print_r($redis->sPop('2people'));


//srandmember隨機返回集合內的元素但不刪除，也可指定要返回的數量。
print_r($redis->sRandMember('people',2));
echo "<hr>";

//srem移除集合中的一个或多个成员元素，不存在的成员元素会被忽略。
print_r($redis->sMembers('people'));
echo "<br>";
$redis->sRem('people','aaron');
echo "<br>";
print_r($redis->sMembers('people'));
echo "<hr>";

//sUnion合併集合
print_r($redis->sUnion('people','2people','3people'));
echo "<hr>";

//sUnionStore合併集合並存入第一個key
$redis->sUnionStore('unionStore','people','2people','3people');
print_r($redis->sMembers('unionStore'));
echo "<hr>";

//sscan第一個參數是集合，第二個為null，第三個為你要找的訊息，
//第四個是你要找幾次，假設今天集合內有6個值你給10他頂多也找6次，若你給他4但他只有前面3個符合條件他只會返回3個。
$it=null;
print_r($redis->sScan('people', $it, 'p*',5));
echo "<hr>";

?>