<?php
$currentDir = dirname($_SERVER['SCRIPT_FILENAME']);
$file =  $currentDir. '/2.php';
$outputfile = $currentDir.'/out.txt';
$pidfile = $currentDir.'/pid.txt';
$cmd = "/e/wnmp/php/php5.3.10/php $file";
echo sprintf("%s > %s 2>&1 & > %s", $cmd, $outputfile, $pidfile);
exec(sprintf("%s > %s 2>&1 &  > %s", $cmd, $outputfile, $pidfile));
?>