<?php
function is_windows(){
	if(PHP_OS == 'WINNT' || PHP_OS == 'WIN32'){
		return true;
	}
	return false;
}
var_dump($_SERVER);
echo "hello";
$php =  dirname($_SERVER['SCRIPT_FILENAME']) . '/2.php';
$command = "/e/wnmp/php/php5.3.10/php $php";
echo $command;
var_dump(is_windows());
if(is_windows()){
	popen('start /b '.$command.'','r');
	echo 'test';
}else{
	pclose(popen($command." > /dev/null &", 'r'));
}
?>