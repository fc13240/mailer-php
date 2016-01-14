<?php
require_once('class.Mail.php');
$conf = require_once('conf.php');
$confGearman = $conf['gearman'];
$worker= new GearmanWorker();
$worker->addServer($confGearman['host'], $confGearman['port']);
$worker->addFunction("send_mail", "send_mail_function");
while (1){
	echo "wating for Job...";
	$code = $worker->work();
	if($worker->returnCode() != GEARMAN_SUCCESS){
		echo 'Fail';
	}
	echo "code:".$code;
}
function send_mail_function($job){
	$data = unserialize($job->workload());
	Mail::send($data['toAddresses'],$data['subject'],$data['content']);
}
?>