<?php
sleep(5);
$file = dirname($_SERVER['SCRIPT_FILENAME']) . '/1.txt';
$f=fopen($file,'a+');
fwrite($f,date('Y-d-m H:i:s').'\n');//当然这一句可以写成循环，wp好像过滤了循环代码，为了保证可执行改为非循环的了
fclose($f);
?>