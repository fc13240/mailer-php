<?php
ob_end_clean();//清除缓冲内容
header('HTTP/1.1 200 Ok');
header("Connection: close");//连接关闭
ob_start();
echo 'running';
$size=ob_get_length();
header("Content-Length: $size");
ob_end_flush();//输出缓冲
flush();
 
sleep(10);
set_time_limit(0);
$f=fopen('test.txt','a+');
fwrite($f,date()." ");//当然这一句可以写成循环，wp好像过滤了循环代码，为了保证可执行改为非循环的了
?>